<?php
/**
 * Created by JetBrains PhpStorm.
 * User: logo
 * Date: 11/10/13
 * Time: 8:52 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Application\API;



use Application\Library\Interval\ThisOrSpecificMonth;
use Application\View\JsonBalance;
use Finance\Balance\BalanceService;
use Finance\Balance\SubsetBalance;
use Finance\Transaction\Transaction;
use Refactoring\Interval\ThisMonth;
use Refactoring\Interval\SpecificMonth;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class Balance extends AbstractRestfulController
{

    /**
     * Should return balance only for one model
     * @param mixed $id
     * @return mixed|JsonModel
     */
    public function get($id)
    {
        return new JsonModel();
    }

    public function create($data)
    {

        $working_month = new SpecificMonth(new \DateTime($data['month']));
        $balance_service = $this->getServiceLocator()->get('\Finance\Balance\BalanceService');
        return new JsonBalance($balance_service->closeMonth($working_month));
    }


    /**
     * @fixme balance needs to be generic
     * @fixme it will be required to select any type of buffer
     * @return mixed|JsonModel
     */
    public function getList()
    {
        $month    =  $this->params()->fromQuery('month', null);

        $day = ($month === null)? new \DateTime() : new \DateTime($month);

        $interval = new SpecificMonth($day);

        /** @var BalanceService $balance_service */
        $balance_service = $this->getServiceLocator()->get('\Finance\Balance\BalanceService');
        $balance  = $balance_service->getBalance($interval);

        return new JsonBalance(new SubsetBalance($balance, 'buffer'));

    }


}