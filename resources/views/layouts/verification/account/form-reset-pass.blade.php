<!DOCTYPE html>
<html lang="id">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Kuis Ovo Saldo - Reset Password</title>
      <style>
         .mainDiv {
         display: flex;
         min-height: 100%;
         align-items: center;
         justify-content: center;
         background-color: #f9f9f9;
         font-family: 'Open Sans', sans-serif;
         }
         .cardStyle {
         width: 500px;
         border-color: white;
         background: #fff;
         padding: 36px 0;
         border-radius: 8px;
         margin: 30px;
         box-shadow: 0px 0 2px 0 rgba(0,0,0,0.25);
         }
         .formTitle{
         font-weight: 600;
         margin-top: 20px;
         color: #2F2D3B;
         text-align: center;
         }
         .inputLabel {
         font-size: 13px;
         color: #555;
         margin-bottom: 6px;
         margin-top: 24px;
         }
         .inputDiv {
         width: 70%;
         display: flex;
         flex-direction: column;
         margin: auto;
         }
         input {
         height: 40px;
         font-size: 16px;
         border-radius: 4px;
         border: none;
         border: solid 1px #ccc;
         padding: 0 11px;
         }
         input:disabled {
         cursor: not-allowed;
         border: solid 1px #eee;
         }
         .buttonWrapper {
         margin-top: 40px;
         }
         .submitButton {
         width: 70%;
         height: 40px;
         margin: auto;
         display: block;
         color: #fff;
         background-color: #7d08f7;
         border-color: #3f047c;
         text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.12);
         box-shadow: 0 2px 0 rgba(0, 0, 0, 0.035);
         border-radius: 4px;
         font-size: 14px;
         cursor: pointer;
         }
         .errorMessage {
         color: red;
         font-size: 11px;
         margin-top: 5px;
         display: none;
         }
         .submitButton:disabled,
         button[disabled] {
         border: 1px solid #cccccc;
         background-color: #cccccc;
         color: #666666;
         }
      </style>
   </head>
   <div class="mainDiv">
      <div class="cardStyle">
         <form action="{{ url('/reset-password') }}" method="POST" name="signupForm" id="signupForm" autocomplete="off">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <h2 class="formTitle">
               RESET PASSWORD
            </h2>
            <div class="inputDiv">
               <label class="inputLabel" for="password">Buat password baru</label>
               <input type="password" id="password" name="password" required>
               <div id="passwordError" class="errorMessage">Password tidak boleh kosong.</div>
            </div>
            <div class="inputDiv">
               <label class="inputLabel" for="confirmPassword">Ulangi password</label>
               <input type="password" id="confirmPassword" name="password_confirmation" required>
               <div id="confirmPasswordError" class="errorMessage">Konfirmasi password tidak cocok.</div>
            </div>
            <div class="buttonWrapper">
               <button type="submit" id="submitButton" onclick="validateSignupForm()" class="submitButton pure-button pure-button-primary">
               <span>SIMPAN</span>
               </button>
            </div>
         </form>
      </div>
   </div>
   <script type="text/javascript">
      function validateSignupForm(event) {
          const password = document.getElementById('password').value;
          const confirmPassword = document.getElementById('confirmPassword').value;
          let valid = true;
      
          document.getElementById('passwordError').style.display = 'none';
          document.getElementById('confirmPasswordError').style.display = 'none';
      
          if (password === '') {
              document.getElementById('passwordError').textContent = 'Password tidak boleh kosong.';
              document.getElementById('passwordError').style.display = 'block';
              valid = false;
          } else if (password.length < 8) {
              document.getElementById('passwordError').textContent = 'Password harus memiliki minimal 8 karakter.';
              document.getElementById('passwordError').style.display = 'block';
              valid = false;
          }
      
          if (password !== confirmPassword) {
              document.getElementById('confirmPasswordError').textContent = 'Konfirmasi password tidak cocok.';
              document.getElementById('confirmPasswordError').style.display = 'block';
              valid = false;
          }
      
          if (!valid) {
              event.preventDefault();
          }
      }
      
      document.getElementById('signupForm').addEventListener('submit', validateSignupForm);
   </script>
   </body>
</html>