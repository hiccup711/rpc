<?php

// 创建套接字
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
/**
字节流 双工通信管道
 * A {hello} 序列化 {01010101020} -> 反序列化 ServerB
 * MSS Maximum Segment Size 单次传输数据最大规则,除去 IP 和 TCP 头部之后，一个网络包所能容纳的 TCP 数据的最大长度
 * 数据包过大,无法一次传输
 * 粘包
 * 拆包:
 * client: 未来 物联 科技 超出 MSS
 * 传输中：未，来，物，联，科，技
 * server: 未来物 联科 技
 * 组包:
 *  client:未
client:来
client:物
client:联
client:科
client:技
传输中：未来物联科技
server: 未来物联科技
 *  Nagle 算法, 网络 IO 消耗-> 等待时间, 200MS  立刻发送(FIN)
 *  网络延迟
 *
 * Server 繁忙
client:未
client:来
client:物
client:联
client:科
client:技
 * TCP Recv Buffer // 缓存区域
 * Server 来取数据
 * Server: 未来物联科技
 *
 * TCP 70 年代, rpc 80, http 90
 * 客户端程序 -> 服务端  c/s 架构 client/server  182.xx.xx.xx:9911
 * 客户端程序 ->
 * 客户端程序 ->
 * 客户端程序 ->
 *
 * 浏览器 -> 服务端  B/S 架构, browser/server
 * 浏览器 -> 服务端  统一的数据传输格式
 * 浏览器 -> 服务端
 * 浏览器 -> 服务端
 * **** 标记数据边界
 * [未][来物][联科技]
 * [请求头][body]
 *
 * http1.1
 * a,[b,c,d]
 * d->a
 * $g = new Guzzle()
 * $g->get('token');
 *
 * a
 * a 创建 api1 接口
 * a 创建 api2 接口
 * a 创建 api3 接口
 * a 创建 api4 接口
 * a 创建 api5 接口
 * a 创建 api6 接口
 * 接口时间消耗
 * http 链接 -> a(keepalive)io
 * 一段时间内多次请求 a
 *
 * rpc // grpc[http2.0]  thrift
 * $d = A()->remoteFunction(request);
 * rpc 结构体可定制化程度 http, 请求包比 http 小
 * d->a
 * d 建立链接, d断开链接  tpc进程池 (10)
 * c tpc进程池 (9)
 * b tpc进程池 (8)
 *
 * RPC请求服务发现
 * d -> a 端口号地址,服务名称
 * c -> a 端口号地址,服务名称
 * b -> a 端口号地址,服务名称
 * 中间服务保存 a 提供的服务
 * consul etcd
 **/

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