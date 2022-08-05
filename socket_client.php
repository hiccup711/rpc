<?php

// 创建套接字
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

// 连接服务端
socket_connect($socket, '127.0.0.1', 8888);

while (true) {
    // 让控制台输入内容
    fwrite(STDOUT, '请输入内容：');
    $in = fgets(STDIN);

    // 向服务端发送内容
    socket_write($socket, $in);

    // 读取服务端发送的消息
    $msg = socket_read($socket, 10240);
    echo $msg;
}