<?php
/**
 * @filesource modules/repair/views/detail.php
 * @link http://www.kotchasan.com/
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 */

namespace Repair\Detail;

use \Kotchasan\DataTable;
use \Kotchasan\Date;
use \Kotchasan\Template;
use \Kotchasan\Province;
use \Kotchasan\Currency;

/**
 * แสดงรายละเอียดการซ่อม
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class View extends \Gcms\View
{
  private $statuses;

  /**
   * module=repair-detail
   *
   * @param object $index
   * @return string
   */
  public function render($index)
  {
    // สถานะการซ่อม
    $this->statuses = \Repair\Status\Model::create();
    // อ่านสถานะการทำรายการทั้งหมด
    $statuses = \Repair\Detail\Model::getAllStatus($index->id);
    // ตาราง
    $table = new DataTable(array(
      /* array datas */
      'datas' => $statuses,
      'onRow' => array($this, 'onRow'),
      /* ส่วนหัวของตาราง และการเรียงลำดับ (thead) */
      'headers' => array(
        'name' => array(
          'text' => '{LNG_Operator}',
        ),
        'status' => array(
          'text' => '{LNG_Repair status}',
          'class' => 'center',
        ),
        'cost' => array(
          'text' => '{LNG_Cost}',
          'class' => 'center',
        ),
        'create_date' => array(
          'text' => '{LNG_Transaction date}',
          'class' => 'center',
        ),
        'comment' => array(
          'text' => '{LNG_Comment}',
        ),
      ),
      /* รูปแบบการแสดงผลของคอลัมน์ (tbody) */
      'cols' => array(
        'status' => array(
          'class' => 'center'
        ),
        'cost' => array(
          'class' => 'right'
        ),
        'create_date' => array(
          'class' => 'center'
        ),
      ),
    ));
    // template
    $template = Template::createFromFile(ROOT_PATH.'modules/repair/views/detail.html');
    $template->add(array(
      '/%NAME%/' => $index->name,
      '/%PHONE%/' => $index->phone,
      '/%ADDRESS%/' => $index->address,
      '/%PROVINCE%/' => Province::get($index->provinceID),
      '/%ZIPCODE%/' => $index->zipcode,
      '/%EQUIPMENT%/' => $index->equipment,
      '/%SERIAL%/' => $index->serial,
      '/%JOB_DESCRIPTION%/' => nl2br($index->job_description),
      '/%CREATE_DATE%/' => Date::format($index->create_date, 'd M Y'),
      '/%APPOINTMENT_DATE%/' => Date::format($index->appointment_date, 'd M Y'),
      '/%APPRAISER%/' => empty($index->appraiser) ? '' : Currency::format($index->appraiser),
      '/%COMMENT%/' => $index->comment,
      '/%DETAILS%/' => $table->render(),
    ));
    return $template->render();
  }

  /**
   * จัดรูปแบบการแสดงผลในแต่ละแถว
   *
   * @param array $item
   * @return array
   */
  public function onRow($item, $o, $prop)
  {
    $item['cost'] = $item['cost'] == 0 ? '' : Currency::format($item['cost']);
    $item['comment'] = nl2br($item['comment']);
    $item['create_date'] = Date::format($item['create_date'], 'd M Y H:i');
    $item['status'] = '<mark class=term style="background-color:'.$this->statuses->getColor($item['status']).'">'.$this->statuses->get($item['status']).'</mark>';
    return $item;
  }
}