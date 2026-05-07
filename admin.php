<?php
session_start();
if (empty($_SESSION['guanliyuan'])): ?>
    <script>
        alert('您暂无权限登录后台！');
            window.location.href = 'index.html';
    </script>
<?php endif; ?>
<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html" />
	<meta name="author" content="大眼仔~旭" />
	<title>会员管理</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<style>
    *{
        margin: 0;
        border: 0;
        padding: 0;
    }
    body{
        background: url("picture/shan.jpg");
        background-size: cover;
    }
    div.search {
        background-color: rgba(255, 255, 255, 0.5);
        margin-top: 20px;
        opacity: clamp(0, 1, 1);
        padding: 5px;
        box-shadow: 0 1px 5px rgba(0, 0, 0, 0.15);
        border-radius: 30px;
        width: 110px;
    }

    .search {
        display: flex;
        justify-content: left;
        text-align: center;
        gap: 10px;
        transition: width 0.3s ease-in-out;
    }

    .search:hover{
        width: 230px;

    }

    #search{
        height: 25px;
        border: none;
        background:linear-gradient(to right, rgba(72, 247, 223, 0.65), rgba(244, 0, 252, 0.88)) no-repeat right bottom;
        background-size: 0 2px;
        transition: background-size 1.5s,width 0.3s ease-in-out;
        line-height: 30px;
        outline: none;
        right: 0;
        width: 77px;
    }
    #search:focus{
        width: 200px;
        background-size: 100% 2px;
        border: none;
        background-position: left bottom;
    }
    .bg{



    }
    .user_table{
        width: 100%;
        height: 100%;
        /*display: flex;*/
        font-size: 20px;
        color: gold;
        text-shadow: #000000 2px 2px 2px;
        justify-content: space-around;
    }
    .user_table_header{
        width: 80vw;
        /*display: flex;*/
        justify-content: space-around;
    }
    .user_list{
        text-align: center;
        margin-top: 40px;
        color: white;
    }
    .delete-button{
        background-color: rgb(255, 0, 0);
        border-radius: 5px;
        color: white;
        padding: 5px 10px;
        cursor: pointer;s
        transition: background-color 0.3s;
        &:hover{
            background-color: rgb(139, 0, 0);
            text-shadow: #000000 2px 2px 2px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
            transform: scale(1.1);
        }
    }
    .upPower_button{
        margin-left: 10px;
        background-color: #20ff01;
        border-radius: 5px;
        color: #007aff;
        padding: 5px 10px;
        cursor: pointer;
        transition: background-color 0.3s;
        &:hover{
            background-color: rgba(3, 110, 249, 0.74);
            color: rgb(32, 255, 1);
            text-shadow: #000000 2px 2px 2px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
            transform: scale(1.1);
        }
    }
    .downPower_button{
        margin-left: 10px;
        background-color: #007aff;
        border-radius: 5px;
        color: #20ff01;
        padding: 5px 10px;
        cursor: pointer;
        transition: background-color 0.3s;
        &:hover{
            background-color: rgba(77, 255, 0, 0.74);
            color: rgb(1, 111, 255);
            text-shadow: #000000 1px 1px 2px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
            transform: scale(1.1);
        }
    }
    .reset_button{
        margin-left: 10px;
        background-color: rgba(111, 111, 111, 0.78);
        border-radius: 5px;
        color: #000000;
        padding: 5px 10px;
        cursor: pointer;
        transition: background-color 0.3s;
        &:hover{
            background-color: rgba(0, 42, 255, 0.74);
            color: rgb(255, 255, 255);
            text-shadow: #000000 1px 1px 2px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
            transform: scale(1.1);
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
    .pagination-button{
        background-color: rgba(255, 255, 255, 0.67);
        width: 30px;
        border-radius: 10px;
        transition: background-color 0.3s ease-in-out,color 0.3s ease-in-out;
        &:hover{
            background-color: rgba(115, 115, 115, 0.89);
            color: rgb(255, 162, 0);
        }
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
</style>
<body>
<div class="bg">
    <h2 align='center'>会员管理页面</h2>
    <div class="search">
        <a href="searchResult.html" onclick="setItem()"><img src="picture/search.png" alt="search" width="20px" height="20px"  style="cursor: pointer"></a>
        <label>
            <input type="text" name="q" spellcheck="true" placeholder="用户查询..." id="search">
        </label>
    </div>
    <div class="back" onclick="location='index.html'"><i class="fa-solid fa-left-long"></i></div>
    <table class="user_table">
        <tr class="user_table_header">
            <th>序号</th>
            <th>用户名</th>
            <th>性别</th>
            <th>邮箱</th>
            <th>操作</th>
        </tr>
        <tbody id="vip_list" class="user_list">

        </tbody>
    </table>
</div>
<div id="pagination" style="text-align:center;margin-top:20px;"></div>
<div id="Dialog">
    <div class="dialog-content" id="dialog-content" style="display: flex; justify-content: space-between; align-items: center;">
        <h3 id="main-content"></h3>
    </div>
</div>

</body>
<script>
    window.onload = function () {
        user_list(1);
    }
    function setItem(){
        const searchQuery = document.getElementById('search').value;
        localStorage.setItem('searchQuery', searchQuery);
    }

    //用户列表
    let currentPage = 1;
    const usersPerPage = 15;
    function user_list(page=1) {
        const tbody = document.getElementById('vip_list');
        currentPage = page;

        fetch('adminGetUser.php')
            .then(response => response.json())
            .then(data => {
                tbody.innerHTML = '';

                if (Array.isArray(data)) {
                    // 分页处理
                    const start = (page-1)*usersPerPage;
                    const end = start+usersPerPage;
                    //对用户数据进行排序、切片
                    const paginatedData = data.slice(start, end);
                    let id = start+1;

                    paginatedData.forEach(record => {
                        const row = document.createElement('tr');

                        // 创建并添加ID单元格
                        const idCell = document.createElement('td');
                        idCell.textContent = String(id);
                        id++;
                        row.appendChild(idCell);

                        // 创建并添加姓名单元格
                        const nameCell = document.createElement('td');
                        nameCell.textContent = record.name;
                        row.appendChild(nameCell);
                        // 创建并添加性别单元格
                        const sexCell = document.createElement('td');
                        if (record.sex === 'male')sexCell.textContent = '男';
                        else sexCell.textContent = '女';

                        row.appendChild(sexCell);
                        // 创建并添加邮箱单元格
                        const emailCell = document.createElement('td');
                        emailCell.textContent = record.email;
                        row.appendChild(emailCell);
                        // 创建并添加删除按钮单元格
                        const controlCell = document.createElement('td');
                        const deleteButton = document.createElement('button');
                        deleteButton.textContent = '删除';
                        deleteButton.className = 'delete-button';
                        deleteButton.addEventListener('click', function () {
                            deleteUser(record.name);
                            user_list();
                        });
                        row.appendChild(deleteButton);
                        // 创建并添加管理员按钮单元格
                        if (record.stats === null) {
                            const statsCell = document.createElement('button');
                            statsCell.textContent = '提权';
                            statsCell.className = 'upPower_button';
                            statsCell.addEventListener('click', function () {
                                upPower(record.name);
                                user_list();
                            })
                            row.appendChild(statsCell);
                        }
                        else if (record.stats === '管理员'){
                            const statsCell = document.createElement('button');
                            statsCell.textContent = '降权';
                            statsCell.className = 'downPower_button';
                            statsCell.addEventListener('click', function () {
                                downPower(record.name);
                                user_list();
                            })
                            row.appendChild(statsCell);
                        }
                        // 创建并添加重置密码按钮单元格
                        const resetButton = document.createElement('button');
                        resetButton.textContent = '重置';
                        resetButton.className = 'reset_button';
                        resetButton.addEventListener('click', function () {
                            resetPassword(record.name);
                        })
                        row.appendChild(resetButton);

                        row.appendChild(controlCell);

                        tbody.appendChild(row);
                    });

                    renderPagination(data.length);
                } else {
                    console.error('返回的数据不是数组:', data);
                }
            })
            .catch(error => {
                console.error('获取预约数据失败:', error);
            });
    }

    // 渲染分页按钮
    function renderPagination(totalUsers) {
        const totalPages = Math.ceil(totalUsers / usersPerPage);
        const paginationDiv = document.getElementById('pagination');
        paginationDiv.innerHTML = ''; // 清空现有页码

        for (let i = 1; i <= totalPages; i++) {
            const button = document.createElement('button');
            button.textContent = i;
            button.style.margin = '0 5px';
            button.className = 'pagination-button';
            button.disabled = i === currentPage;

            button.addEventListener('click', () => {
                user_list(i); // 切换到指定页码
            });

            paginationDiv.appendChild(button);
        }
    }

    async function deleteUser(name) {
        if (confirm('该过程不可逆，是否继续？')) {
            if (confirm(`确定要删除"${name}"账号吗？`)) {
                try {
                    const response = await fetch('adminDeleteUser.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `username=${encodeURIComponent(name)}`
                    });
                    const result = await response.text();
                    if (result === "成功")
                        remind("删除成功");
                    else if (result === "失败")
                        remind("删除失败，请稍后再试！");
                }
                catch (error) {
                    remind('出现错误，请稍后重试');
                }
                user_list();
            }
        }
    }
    function upPower(name) {
        const params = new URLSearchParams();
        params.append('username', name);
        params.append('number', '1');

        fetch('changePower.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: params.toString()
        })
            .then(response => response.text())
            .then(data => {
                if (data === '成功') remind('提权成功！');
                else remind('提权失败！');
            })
            .catch(error => {
                console.error('提权失败:', error);
            });
    }
    function downPower(name) {
        if(name==='admin'){
            remind('无法降权！');
            return;
        }
        const params = new URLSearchParams();
        params.append('username', name);
        params.append('number', '2');

        fetch('changePower.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: params.toString()
        })
            .then(response => response.text())
            .then(data => {
                if (data === '成功') remind('降权成功！');
                else remind('提权失败！');
            })
            .catch(error => {
                console.error('降权失败:', error);
            });
    }
    function resetPassword(name){
        const params = new URLSearchParams();
        params.append('username', name);
        params.append('number', '3');

        fetch('changePower.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: params.toString()
        })
            .then(response => response.text())
            .then(data => {
                if (data === '成功') remind('重置密码成功！');
                else remind('重置密码失败！');
            })
            .catch(error => {
                console.error('重置失败:', error);
            });
    }
    function remind(n) {
        document.getElementById('Dialog').style.display = 'block';
        document.getElementById('main-content').textContent = n;
        setTimeout(function () {
            document.getElementById('Dialog').style.display = 'none';
        }, 3000);
    }
    // document.addEventListener('mousemove',function (evet) {
    //     const x = evet.clientX / window.innerWidth;
    //     const y = evet.clientY / window.innerHeight;
    //     document.tbody.style.background = `linear-gradient(to right,rgba(255,0,0,${x}),rgba(0,0,255,${y})`;
    // })
</script>
</html>