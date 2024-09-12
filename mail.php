<html>
    <head>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: white;
                color: #141317;
                margin: 0;
                padding: 0;
                text-align: center;
            }
            .container {
                background-color: white;
                padding: 20px;
                border-radius: 10px;
                max-width: 600px;
                margin: 0 auto;
            }
            .header {
                font-size: 24px;
                color: black;
                margin-bottom: 20px;
            }
            .content {
                display: flex;
                flex-direction: column;
                align-items: center;
                font-size: 16px;
                color: black;
                margin-bottom: 30px;
                text-align: center;
            }
            .button-container {
                margin: 20px 0;
            }
            .button {
                background-color: #6b3bf4;
                color: #fff;
                text-decoration: none;
                padding: 15px 25px;
                border-radius: 50px;
                font-size: 18px;
                transition: background-color 0.3s ease;
            }
            .button:hover {
                background-color: #5a2bd9;
            }
            .footer {
                font-size: 12px;
                color: #dcdde1;
                margin-top: 30px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                Bienvenue dans AI LIBERTY  <?php echo $prenom; ?> !
            </div>
            <div class="content">
                Merci de rejoindre notre plateforme. Cliquez sur le bouton ci-dessous pour vérifier votre compte :
            </div>
            <div class="button-container">
                <a href="ai-liberty.fr/verify.php?code=' . $cle . '" class="button">Vérifier mon compte</a>
            </div>
            <div class="footer">
                Si vous n\'avez pas demandé cette vérification, vous pouvez ignorer cet email.
            </div>
        </div>
    </body>
    </html>