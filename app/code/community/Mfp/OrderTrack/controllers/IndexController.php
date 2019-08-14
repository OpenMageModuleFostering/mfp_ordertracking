<?php
class Mfp_OrderTrack_IndexController extends Mage_Core_Controller_Front_Action{
    public function IndexAction() {
      
	  $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("Order Track"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home Page"),
                "title" => $this->__("Order Track"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("Order Track", array(
                "label" => $this->__("Order Track"),
                "title" => $this->__("Order Track")
		   ));

      $this->renderLayout(); 
	  
    }
	
		public function OrderDetailsAction()
	{
	     $data = $this->getRequest()->getPost();
     $orderId = $data['orderid'];
	 $resource = Mage::getSingleton('core/resource');
	 $read= $resource->getConnection('core_read');
     $str = 	"select  * from  sales_flat_order inner join sales_flat_shipment_track where 
	 sales_flat_shipment_track.order_id  =  sales_flat_order.entity_id and sales_flat_order.increment_id = $orderId";
	 $ordertrack = $read->fetchRow($str);
	 $ordid = $ordertrack['increment_id'];
	 $ord_status = $ordertrack['status'];
	 $tracking_number = $ordertrack['track_number'];
	 $title = $ordertrack['title'];
$status = Mage::getStoreConfig('ordertrack_section/ordertrack_group/orderstatus');
$carrier = Mage::getStoreConfig('ordertrack_section/ordertrack_group/ordercarrier');
$track_number = Mage::getStoreConfig('ordertrack_section/ordertrack_group/ordertrack');
if($ordertrack != '')
{
	 $msg .= "<h1>Order Tracking Details</h1>

	 
	 <table border='1' style='width:100%'>
  <tr>
    <td>Order Id </td>
    <td>$ordid</td>		
  </tr> ";
  if($status == 1)
  {
    $msg .= "<tr>
    <td>Order Status</td>
    <td>$ord_status</td>		
  </tr>";
  }
  if($carrier == 1)
  {
 $msg .= " <tr>
    <td>Carrier</td>
    <td>$title</td>		
  </tr>";
 } 
 if($track_number == 1)
 {
  $msg .="<tr>
    <td>Tracking Number </td>
    <td>$tracking_number</td>		
  </tr>";
  }
  $msg .="</table>";
	 echo $msg;
	}else {
	echo "<h1>No Tracking Details Availables</h1>";
	}}
}