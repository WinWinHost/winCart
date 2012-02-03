$(document).ready(function(){
   //hide all bloks and display first
   $('.block').css('display', 'none');
   $('.block:first').css('display', 'block');
   
   //Step1 from Intro
   $('#intro .submit').click(function(){
       $('#intro').css('display', 'none');
       $('#step1').css('display', 'block');
   });
//   var db = new Array(); 
//   $('form').submit(function(){
//      //var form = $('#database-settings');
//      //extract form vars
//       
//      db[0] = this.hostname.value;
//      db[1] = this.database.value;
//      db[2] = this.username.value;
//      db[3] = this.password.value;
//      
//      $.post('check.php', db, function(data){
//          alert(data);
//      });
//      
//      preventDefault();
//   });
   
   //Step2 from Step1
   $('#step1 input[name~="submit"]').click(function(){
       $('#step1').css('display', 'none');
       $('#step2').css('display', 'block');
   });
   
   //Finish from Step2
   $('#step2 .submit').click(function(){
       $('#step2').css('display', 'none');
       $('#done').css('display', 'block');
   });
   
});



//test database pushed
