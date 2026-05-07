<?php
session_start();
$logged=$_SESSION['logged'];
if($logged){
    echo "<h2 style='text-align: right'>您好！欢迎$logged</h2><p style='text-align: right'><a href='pwmodify.html'><i class='fa-solid fa-lock' style='color: grey'>修改密码</i></a> <a href='logout.php'><i class='fa-solid fa-right-from-bracket' style='color: red'>退出登录</i></a></p>";
}else{
    echo "<script>alert('请登录后上传文件');location.href='login.php';</script>";
    exit;
}

?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html" />
    <meta name="author" content="大眼仔~旭" />
    <title>文件上传</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<style>
    *{
        margin: 0;
        padding: 0;
    }
    body{
        background:url("picture/yun.jpg");
        background-size: cover;
        background-repeat: no-repeat;
    }
    .main_content{
        width: 50%;
        height: 50%;
        background-color: rgba(255, 255, 255, 0.19);
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        border-radius: 10px;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .rows{
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }
    .rows input{
        display: flex;
        align-items: center;
        justify-content: space-around;
    }
    .back{
        position: absolute;
        width: 25px;
        left: 10px;
        top: 2%;
        text-align: center;
        transition: transform 0.2s ease-out,color 0.2s ease-out;
        background: rgba(184, 184, 184, 0.52);
        border-radius: 10px;
    }
    .back:hover{
        color: rgba(86, 86, 86, 0.42);
        transform: scale(1.2);
    }
    .btn{
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
        width: 100%;
    }
    .btn input{
        width: 100px;
        height: 30px;
        border: none;
        background: rgba(255, 255, 255, 0.52);
        border-radius: 10px;
        cursor: pointer;
        color: rgba(0, 0, 0, 0.91);
        transition: transform 0.2s ease-out,background-color 0.2s ease-out;
        &:hover{
            background-color: rgba(255, 255, 255, 0.79);
            transform: scale(1.1);
        }
        &:active{
            background-color: rgba(255, 255, 255, 0.79);
            transform: scale(0.9);
            color: rgba(0, 0, 0, 0.44);
        }
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
    #fileList{
        padding: 10px;
        max-width: 20%;
        background-color: rgba(238, 238, 238, 0.55);
        border-radius: 10px;
    }
</style>
<body>
<div>
    <div class="main_content">
        <form action="toFile.php" method="post"  enctype="multipart/form-data" target="hiddenFrame">
            <table>
                <tr class="rows">
                    <td>课程设计报告</td>
                    <td><input type="file" name="myfile[]" /></td>
                </tr>
                <tr class="rows">
                    <td>源代码</td>
                    <td><input type="file" name="myfile[]" /></td>
                </tr>
            </table>
            <div class="btn">
            <input type="submit" value="提交" name='submit'/>
            <input type="reset" value="清空"/>
            </div>
        </form>
    </div>
</div>
<!-- 在页面中添加显示文件列表的区域 -->
<div id="fileList" style="margin-top: 30px;">
    <h3>您的文件：</h3>
    <ul id="fileItems"></ul>
</div>
<div id="Dialog">
    <div class="dialog-content" id="dialog-content" style="display: flex; justify-content: space-between; align-items: center;">
        <h3 id="main-content"></h3>
    </div>
</div>
<div class="back" onclick="location='index.html'"><i class="fa-solid fa-left-long"></i></div>
<iframe name="hiddenFrame" style="display:none;"></iframe>
</body>
<script>
    // 页面加载时获取文件列表
    window.onload = function() {
        fetch('getFile.php')
            .then(response => response.json())
            .then(files => {
                console.log("服务器返回的文件名列表：", files); // 调试信息
                const fileItems = document.getElementById('fileItems');
                if (files.length === 0) {
                    fileItems.innerHTML = '<li>暂无文件</li>';
                    return;
                }
                files.forEach(file => {
                    const li = document.createElement('li');
                    const a = document.createElement('a');
                    a.href = '#';
                    a.style= "text-decoration: underline;";
                    a.textContent = file; // 这里展示的是服务器返回的文件名
                    a.onclick = () => downloadFile(file);
                    li.appendChild(a);
                    fileItems.appendChild(li);
                });
            })
            .catch(error => console.error('获取文件失败:', error));
    };

    // 下载文件函数
    async function downloadFile(filename) {
        const choice = confirm("是否发送至邮箱？\n点击“确定”发送至邮箱，点击“取消”下载到本地");
        if (choice) {
            //发送文件的邮件
            try {
                const url = `sendFile.php?file=${encodeURIComponent(filename)}`;
                const response = await fetch(url);
                const result = await response.json();
                if (result.success) {
                    alert("文件已成功发送至您的邮箱！");
                } else {
                    alert("发送邮件失败：" + (result.message || "未知错误"));
                }
            } catch (error) {
                console.error("邮件发送失败:", error);
                alert("发送邮件失败，请稍后再试。");
            }
        } else {
            //本机下载方式
            const url = `download.php?file=${encodeURIComponent(filename)}`;
            const response = await fetch(url);
            const blob = await response.blob();
            const fileUrl = window.URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = fileUrl;
            link.download = filename;
            document.body.appendChild(link);
            link.click();
            window.URL.revokeObjectURL(fileUrl);
            document.body.removeChild(link);
        }
    }

    function remind(n) {
        document.getElementById('Dialog').style.display = 'block';
        document.getElementById('main-content').textContent = n;
        setTimeout(function () {
            document.getElementById('Dialog').style.display = 'none';
        }, 3000);
    }
    document.querySelector("form").addEventListener("submit", function(e) {
        const files = document.querySelectorAll("input[type='file']");
        let hasFile = false;
        files.forEach(input => {
            if (input.files.length > 0) hasFile = true;
        });
        if (!hasFile) {
            e.preventDefault();
            alert("请选择至少一个文件进行上传！");
        }
    });
    document.querySelector("form").addEventListener("submit", function(e) {
        const reportInput = document.querySelectorAll("input[type='file']")[0];
        const sourceInput = document.querySelectorAll("input[type='file']")[1];

        const allowedReportExts = [".doc", ".docx", ".wps", ".pdf"];
        const allowedSourceExts = [".zip", ".rar", ".7z", ".tar", ".gz", ".bz2", ".xz", ".tar.gz", ".tar.bz2", ".tar.xz"];

        const files = [reportInput.files[0], sourceInput.files[0]];

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            if (file) {
                const name = file.name.toLowerCase();
                const ext = name.substring(name.lastIndexOf('.'));

                if (i === 0 && !allowedReportExts.includes(ext)) {
                    e.preventDefault();
                    alert("课程设计报告必须为 doc/docx/wps 格式");
                    return;
                }

                if (i === 1 && !allowedSourceExts.includes(ext)) {
                    e.preventDefault();
                    alert("源代码必须为 zip/rar 格式");
                    return;
                }
            }
        }
    });

</script>
</html>