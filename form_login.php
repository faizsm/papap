<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Login</title>
</head>
<body>
    <table width='30%' border='0' align='center'>
        <form id="loginForm" method="POST" action="login.php">
            <tr>
                <th colspan="3">FORM LOGIN</th>
            </tr>
            <tr>
                <td>Username</td>
                <td>:</td>
                <td><input type='text' name='user' size='30'></td>
            </tr>
            <tr>
                <td>Password</td>
                <td>:</td>
                <td><input type='password' name='pass' size='30'></td>
            </tr>
            <tr>
                <th colspan="3"><input type='submit' name='fLogin' value='OK'></th>
            </tr>
        </form>
    </table>
</body>
</html>
