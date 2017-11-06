<?php
namespace App\Cron;
use \App\Models\Item;
use \App\Models\UserItem;
use \App\Models\ReportedItem;
use Slim\Container;
/**
*
*/
class CronJob
{
    protected $container;
	public function __construct(Container $container)
	{
		return $this->container = $container;
	}
	public function __get($property)
	{
		return $this->container->{$property};
	}
    public function running()
    {
        $this->unreportedItem();
        $this->itemReappear();
    }
    //User unreported item
    public function unreportedItem()
    {
        $items = new Item($this->db);
        $users = new \App\Models\Users\UserModel($this->db);
        $unreported = new \App\Models\UnreportedItem($this->db);
        $user  = $users->getAllUser()->fetchAll();
        foreach ($user as $value) {
            $userItems = $items->userUnreported($value['id']);
            if ($userItems) {
                foreach ($userItems as  $val) {
                    $data = [
                        'item_id' => $val['id'],
                        'user_id' => $value['id'],
                        'date'    => $val['end_date'],
                    ];
                    $unreported->create($data);
                }
            }
        }
    }
}
?>
