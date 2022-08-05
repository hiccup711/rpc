<?php

// 创建套接字
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

// 设置 ip 被释放后立即可使用
socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, true);

// 绑定ip与端口
socket_bind($socket, 0, 8888);

// 开始监听
socket_listen($socket);

while (true) {
    $i = 0;
    // 接收内容
    $conn_sock = socket_accept($socket);
    socket_getpeername($conn_sock, $ip, $port);
    // echo '请求ip: ' . $ip . PHP_EOL . '端口: ' . $port;

    while (true) {
        // 获取消息内容
        $msg = socket_read($conn_sock, 10240);
        // TODO 处理业务逻辑

        // 将信息转为大写并原样返回客户端
        socket_write($conn_sock, strtoupper($msg));

        echo $msg;
    }
}