<?php
/*
 * @filesource modules/repair/controllers/home.php
 * @link http://www.kotchasan.com/
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 */

namespace Repair\Home;

use \Kotchasan\Http\Request;

/**
 * Controller สำหรับการแสดงผลหน้า Home
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Controller extends \Kotchasan\KBase
{

  /**
   * ฟังก์ชั่นสร้าง card
   *
   * @param Request $request
   * @param \Kotchasan\Html $card
   * @param array $login
   */
  public static function addCard(Request $request, $card, $login)
  {
    \Index\Home\Controller::renderCard($card, 'icon-tools', 'Repair list', \Repair\Home\Model::getNew($login), 'Job today', 'index.php?module=repair-setup'.(isset(self::$cfg->repair_first_status) ? '&amp;status='.self::$cfg->repair_first_status : ''));
  }
}