<?php
session_start();
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html" />
    <meta charset="UTF-8">
    <meta name="author" content="大眼仔~旭" />
    <title>用户登录</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        *{
            padding: 0;
            margin: 0;
        }
        body{
            background:url("picture/shan.jpg");
            background-size: cover;
            background-repeat: no-repeat;
        }
        .main_content{
            background-color: rgba(255, 255, 255, 0.19);
            /*margin-left: 40%;*/
            /*margin-right: 40%;*/
            margin-top: 15%;
            padding-top: 50px;
            padding-bottom: 40px;
            border-radius: 20px;
            box-shadow: rgba(0, 0, 0, 0.47) 1px 2px 5px ;
        }
        h1{
            text-align: center;
            padding-bottom: 20px;
        }
        .login_table{
            display: flex;
            justify-content: space-around;
        }
        .login_table input{
            height: 25px;
            /*width: 150px;*/
            border: none;
            background:linear-gradient(to right, rgba(178, 254, 250, 0.65), rgba(14, 210, 247, 0.8)) no-repeat right bottom;
            background-size: 0 2px;
            transition: background-size 1.5s;
            line-height: 30px;
            outline: none;
        }
        .login_table input:focus{
            background-size: 100% 2px;
            border: none;
            background-position: left bottom;
        }
        .reg_table{
            display: flex;
            justify-content: space-around;
        }
        .reg_table input{
            height: 30px;
            border: none;
            background:linear-gradient(to right, rgba(178, 254, 250, 0.65), rgba(14, 210, 247, 0.8)) no-repeat right bottom;
            background-size: 0 2px;
            transition: background-size 1.5s;
            line-height: 30px;
            outline: none;
        }
        .reg_table input:focus{
            background-size: 100% 2px;
            border: none;
            background-position: left bottom;
        }
        .reg_table td:first-child{
            width: 100px;
            text-align: center;
            align-items: center;
        }
        .f_btn{
            margin-top: 30px;
            display: flex;
            justify-content: space-around;
        }
        .f_btn{
            margin-top: 30px;
            display: flex;
            justify-content: space-around;
        }
        .btn{
            cursor: pointer;
            background-color: rgba(255, 255, 255, 0.35);
            border: none;
            border-radius: 10px;
            width: 50px;
            height: 20px;
            text-align: center;
            transition: transform 0.2s ease-out, box-shadow 0.2s ease-out;
        }
        .btn:hover{
            transform: translateY(-3px);
            box-shadow: rgba(0, 0, 0, 0.6) 1px 3px 5px;
            background-color: rgba(255, 255, 255, 0.5);
        }
        .back{
            position: absolute;
            width: 25px;
            left: 10px;
            top: 2%;
            text-align: center;
            transition: transform 0.2s ease-out,color 0.2s ease-out;
            background: rgba(244, 245, 245, 0.52);
            border-radius: 10px;
        }
        .back:hover{
            color: rgba(86, 86, 86, 0.42);
            transform: scale(1.2);
        }
        .card-container {
            perspective: 800px;
            width: 400px;
            margin: 40px auto;
        }

        .card {
            margin-top: 50%;
            position: relative;
            width: 100%;
            height: auto;
            transform-style: preserve-3d;
            transition: transform 1s;
        }

        .card.flipped {
            transform: rotateY(180deg);
        }

        .card-front,
        .card-back {
            position: absolute;
            width: 100%;
            backface-visibility: hidden;
            background-color: rgba(255, 255, 255, 0.19);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            padding: 10px;
        }

        .card-back {
            transform: rotateY(180deg);
        }
        #Dialog{
            display: none;
            position: fixed;
            text-align: center;
            justify-content: space-around;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(255, 255, 255, 0.71);
            padding: 20px;
            border-radius: 15px;
        }
        #dialog-content{
            display: flex;
            justify-content: space-between;
        }
        #dialog-content,h3{
            flex-direction: column;
        }


    </style>
</head>
<body>
<div class="card-container" id="cardContainer">
    <div class="card">
        <!-- 前面：登录表单 -->
        <div class="card-front">
            <div class="main_content" id="login">
                <div class="back" onclick="location='index.html'"><i class="fa-solid fa-left-long"></i></div><h1>用户登录</h1>
                <div class="login_table">
                    <form action="toLogin.php" method="post" target="hiddenFrame">
                        <table>
                            <tr>
                                <td>用户名:</td>
                                <td><label for="username"></label><input type="text" name="username" id="username" required/></td>
                            </tr>
                            <tr>
                                <td>密&nbsp;&nbsp;&nbsp;&nbsp;码:</td>
                                <td><label for="pw"></label><input type="password" name="pw" id="pw" required/></td>
                            </tr>
                            <tr>
                                <td>验证码:</td>
                                <td>
                                    <label>
                                        <input type="text" name="code" required/>
                                        <?php
                                        $code='';
                                        $yzstr = implode('', range('a', 'z')) .
                                            implode('', range('A', 'Z')) .
                                            implode('', range(0, 9));
                                        for($i=1;$i<=4;$i++){
                                            $code.=$yzstr[mt_rand(0,strlen($yzstr)-1)];
                                        }
                                        echo $code;
                                        $_SESSION['captcha']=$code;
                                        ?>
                                    </label>
                                </td>
                            </tr>
                        </table>
                        <div class="f_btn">
                            <button type="reset" value="清空" class="btn">清空</button>
                            <button type="submit" value="登录" class="btn">登录</button>
                            <button type="button" onclick="flip()" class="btn">去注册</button>
                            <button type="button" onclick="location='emailLogin.html'" class="btn">免密登</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- 后面：注册表单 -->
        <div class="card-back">
            <div class="main_content">
                <h1>用户注册</h1>
                <div class="reg_table">
                    <form action="reg.php" method="post" target="hiddenFrame">
                        <table>
                            <tr>
                                <td>用户名</td>
                                <td><label for="nickname"></label><input type="text" name="nickname" id="nickname" required/></td>
                            </tr>
                            <tr>
                                <td>密&nbsp;&nbsp;&nbsp;&nbsp;码</td>
                                <td><label for="ps"></label><input type="password" name="ps" id="ps" required/></td>
                            </tr>
                            <tr>
                                <td>确认密码</td>
                                <td><label for="cps"></label><input type="password" name="cps" id="cps" required/></td>
                            </tr>
                            <tr>
                                <td>邮&nbsp;&nbsp;&nbsp;&nbsp;箱</td>
                                <td><label>
                                        <input type="text" name="email" id="email" required/>
                                    </label></td>
                            </tr>
                            <tr>
                                <td>性&nbsp;&nbsp;&nbsp;&nbsp;别</td>
                                <td><label>
                                        <input type="radio" name="sex" value="male"/>
                                        男
                                    </label>
                                    <label>
                                        <input type="radio" name="sex" value="female"/>
                                        女
                                    </label></td>
                            </tr>
                            <tr>
                                <td>爱&nbsp;&nbsp;&nbsp;&nbsp;好</td>
                                <td><label>
                                        <input type="checkbox" name="hobby[]" value="football"/>
                                        足球
                                    </label>
                                    <label>
                                        <input type="checkbox" name="hobby[]" value="basketball"/>
                                        篮球
                                    </label>
                                    <label>
                                        <input type="checkbox" name="hobby[]" value="music"/>
                                        音乐
                                    </label></td>
                            </tr>
                            <tr>
                                <td>验证码</td>
                                <td><label for="code">
                                        <input type="text" name="code" required id="code"/>
                                    </label></td>
                            </tr>
                        </table>
                        <div onclick="sendCode()" style="display: flex; justify-content: center; align-items: center;cursor: pointer;background-color: chocolate;border-radius: 10px;color: white" id="sendCodeBtn">发送验证码</div>
                        <div class="f_btn">
                            <button type="reset" value="清空" class="btn">清空</button>
                            <button type="button" onclick="validateAndSubmit()" class="btn">注册</button>
                            <button type="button" onclick="flip()" class="btn">去登录</button>
                        </div>
                    </form>

                    <div class="back" onclick="location='index.html'"><i class="fa-solid fa-left-long"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="Dialog">
    <div class="dialog-content" id="dialog-content" style="display: flex; justify-content: space-between; align-items: center;">
        <h3 id="main-content"></h3>
    </div>
</div>
<iframe name="hiddenFrame" style="display:none;"></iframe>

</body>

<script>
    function flip() {
        const card = document.getElementById('cardContainer').querySelector('.card');
        card.classList.toggle('flipped');
    }

    function remind(n) {
        document.getElementById('Dialog').style.display = 'block';
        document.getElementById('main-content').textContent = n;
        setTimeout(function () {
            document.getElementById('Dialog').style.display = 'none';
        }, 3000);
    }

    function validateAndSubmit() {
        const code = document.getElementById('code').value.trim();
        if (!code) {
            window.parent.remind('请输入验证码');
            return;
        }
        const emailCode = window.emailCode;
        const emailCodeExpires = window.emailCodeExpires;
        if (!emailCode || !emailCodeExpires) {
            window.parent.remind('请先获取验证码');
            return;
        }
        if (Math.floor(Date.now() / 1000) > emailCodeExpires) {
            window.parent.remind('验证码已过期，请重新发送');
            return;
        }
        if (code === emailCode) {
            window.parent.remind('验证码正确！正在提交...');
            document.querySelector('.reg_table form').submit();
        } else {
            window.parent.remind('验证码错误，请重新输入');
        }
    }

    function sendCode() {
        const username = document.getElementById('nickname').value.trim();
        const ps = document.getElementById('ps').value.trim();
        const email = document.getElementById('email').value.trim();
        if (!username || !ps || !email) {
            window.parent.remind('请输入必要信息！');
            return;
        }
        const sendCodeBtn = document.getElementById('sendCodeBtn');
        if (!sendCodeBtn) return;

        // 设置初始倒计时状态
        let countdown = 60;
        sendCodeBtn.style.pointerEvents = 'none';
        sendCodeBtn.textContent = `${countdown} 秒后重发`;
        const timer = setInterval(() => {
            countdown--;
            if (countdown <= 0) {
                clearInterval(timer);
                sendCodeBtn.textContent = '发送验证码';
                sendCodeBtn.style.pointerEvents = 'auto';
                sendCodeBtn.style.background = 'chocolate';
                sendCodeBtn.style.color = 'white';
            } else {
                sendCodeBtn.textContent = `${countdown} 秒后重发`;
                sendCodeBtn.style.background = 'rgba(163,162,162,0.76)';
                sendCodeBtn.style.color = 'black';
            }
        }, 1000);

        // 发送请求获取验证码
        fetch('sendCode.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `email=${encodeURIComponent(email)}`
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // 保存验证码和过期时间到全局或 session
                    window.emailCode = data.code;
                    window.emailCodeExpires = data.expires; // 新增：保存过期时间

                    window.parent.remind('验证码已发送至您的邮箱，请注意查收！');
                } else {
                    window.parent.remind(data.message);
                }
            })
            .catch(error => {
                console.error('发送验证码失败:', error);
                window.parent.remind('网络错误，请重试');
            });
    }
</script>
</html>