<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace App\Controller;

use App\Rpc\CalculatorServiceInterface;

class IndexController extends AbstractController
{
    /**
     * //在这里我们注入了一个接口类，并直接调用接口的add方法，但在本项目并没有add
    方法的实现，真正的add方法在服务提供者里已经实现了，hyperf会帮我们找到相应服务并使用
     * @Inject()
     * @var CalculatorServiceInterface
     */
    private $calculatorService;

    public function index()
    {
        echo '??????';
        return $this->calculatorService->add(1,2);
    }
}
