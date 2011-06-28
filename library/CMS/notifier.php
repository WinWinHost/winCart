<?php
class Application_Service_Notifier_Error
{
    protected $_environment;
    protected $_mailer;
    protected $_session;
    protected $_error;
    protected $_profiler;

    public function __construct(
        $environment,
        ArrayObject $error,
        Zend_Mail $mailer,
        Zend_Session_Namespace $session,
        Zend_Db_Profiler $profiler,
        Array $server)
    {
        $this->_environment = $environment;
        $this->_mailer = $mailer;
        $this->_error = $error;
        $this->_session = $session;
        $this->_profiler = $profiler;
        $this->_server = $server;
    }

    public function getFullErrorMessage()
    {
        $message = '';

        if (!empty($this->_server['SERVER_ADDR'])) {
            $message .= "Server IP: " . $this->_server['SERVER_ADDR'] . "\n";
        }

        if (!empty($this->_server['HTTP_USER_AGENT'])) {
            $message .= "User agent: " . $this->_server['HTTP_USER_AGENT'] . "\n";
        }

        if (!empty($this->_server['HTTP_X_REQUESTED_WITH'])) {
            $message .= "Request type: " . $this->_server['HTTP_X_REQUESTED_WITH'] . "\n";
        }

        $message .= "Server time: " . date("Y-m-d H:i:s") . "\n";
        $message .= "RequestURI: " . $this->_error->request->getRequestUri() . "\n";

        if (!empty($this->_server['HTTP_REFERER'])) {
            $message .= "Referer: " . $this->_server['HTTP_REFERER'] . "\n";
        }

        $message .= "Message: " . $this->_error->exception->getMessage() . "\n\n";
        $message .= "Trace:\n" . $this->_error->exception->getTraceAsString() . "\n\n";
        $message .= "Request data: " . var_export($this->_error->request->getParams(), true) . "\n\n";

        $it = $this->_session->getIterator();

        $message .= "Session data:\n\n";
        foreach ($it as $key => $value) {
            $message .= $key . ": " . var_export($value, true) . "\n";
        }
        $message .= "\n";

        $query = $this->_profiler->getLastQueryProfile()->getQuery();
        $queryParams = $this->_profiler->getLastQueryProfile()->getQueryParams();

        $message .= "Last database query: " . $query . "\n\n";
        $message .= "Last database query params: " . var_export($queryParams, true) . "\n\n";

        return $message;
    }

    public function getShortErrorMessage()
    {
        $message = '';

        switch ($this->_environment) {
            case 'live':
                $message .= "It seems you have just encountered an unknown issue.";
                $message .= "Our team has been notified and will deal with the problem as soon as possible.";
                break;
            default:
                $message .= "Message: " . $this->_error->exception->getMessage() . "\n\n";
                $message .= "Trace:\n" . $this->_error->exception->getTraceAsString() . "\n\n";
        }

        return $message;
    }

    public function notify()
    {
        if (!in_array($this->_environment, array('live', 'stage'))) {
            return false;
        }

        $this->_mailer->setFrom('do-not-reply@domain.com');
        $this->_mailer->setSubject("Exception on Application");
        $this->_mailer->setBodyText($this->getFullErrorMessage());
        $this->_mailer->addTo('alerts@domain.com');

        return $this->_mailer->send();
    }
}
