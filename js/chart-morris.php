<?php 
//include_once '../includes/config.inc.php';

$prestations = $db->get_rows("SELECT * FROM prestation WHERE prestation.id_company='".$_SESSION['User']['id_company']."'");

					$h = 0; 
					$m = 0;
					
					foreach($prestations as $k=>$v):
						$explode = explode(':',$v['time']);
						$h += $explode['0'];
						$m += $explode['1'];
					endforeach;
					
					$total_hour = $h.'h:'.$m;
					
					$total_min = ($h*60) + $m;
					
					/*proforma*/
$invoices = $db->get_rows("SELECT invoice.* FROM invoice WHERE invoice.id_company='".$_SESSION['User']['id_company']."' AND invoice.type='0' AND invoice.active='0'");

					$h_proforma = 0; 
					$m_proforma = 0;

					foreach($invoices as $in => $i):
					
						$invoice_prestations_proforma = $db->get_rows("SELECT * FROM invoice_prestation INNER JOIN prestation ON invoice_prestation.id_prestation = prestation.id_prestation WHERE invoice_prestation.id_invoice='".$i['id_invoice']."'");
					
						
						
						foreach($invoice_prestations_proforma as $k=>$v):
							$explode = explode(':',$v['time']);
							$h_proforma += $explode['0'];
							$m_proforma += $explode['1'];
						endforeach;
											
					endforeach;
					
					if($m_proforma<10){
						$m_proforma = '0'.$m_proforma;
					}
					
					$total_hour_proforma = $h_proforma.'h:'.$m_proforma;
					$total_min_proforma = ($h_proforma*60) + $m_proforma;
					
					$per_proforma = sprintf('%0.2f',($total_min_proforma * 100) / $total_min);
					
					/*invoiced*/
$invoices = $db->get_rows("SELECT invoice.* FROM invoice WHERE invoice.id_company='".$_SESSION['User']['id_company']."' AND invoice.type='0' AND invoice.active='1'");

$total = 0;

					$h_invoiced = 0; 
					$m_invoiced = 0;

					foreach($invoices as $in => $i):
					
						$invoice_prestations = $db->get_rows("SELECT * FROM invoice_prestation INNER JOIN prestation ON invoice_prestation.id_prestation = prestation.id_prestation WHERE invoice_prestation.id_invoice='".$i['id_invoice']."'");
					
						
						
						foreach($invoice_prestations as $k=>$v):
							$explode = explode(':',$v['time']);
							$h_invoiced += $explode['0'];
							$m_invoiced += $explode['1'];
						endforeach;
						
						$total += $i['amount'];
											
					endforeach;
					
					if($m_invoiced<10){
						$m_invoiced = '0'.$m_invoiced;
					}
					
					$total_hour_invoiced = $h_invoiced.'h:'.$m_invoiced;
					$total_min_invoiced = ($h_invoiced*60) + $m_invoiced;
					
					$per_invoiced = sprintf('%0.2f',($total_min_invoiced * 100) / $total_min);
					
					$per_not_invoiced = 100 - ($per_invoiced+$per_proforma);
					
					
					$return = array('total_hour'=>$total_min ,'proforma'=>$per_proforma,'total_hour_invoiced'=>$per_invoiced);
					
					//echo json_encode($return);
					
					

?>
<script type="text/javascript">
/**
 * @Package: Ultra Admin HTML Theme
 * @Since: Ultra 1.0
 * This file is part of Ultra Admin Theme HTML package.
 */


jQuery(function($) {

    'use strict';

    var ULTRA_SETTINGS = window.ULTRA_SETTINGS || {};

    /*--------------------------------
        Morris Chart
     --------------------------------*/
    ULTRA_SETTINGS.chartMorris = function() {


        /*Area Graph*/
		
		/*Donut Graph*/
        Morris.Donut({
            element: 'morris_donut_graph',
            data: [
			{
                value: <?php echo $per_invoiced ?>,
                label: 'Facturés <?php echo $total_hour_invoiced; ?> - <?php echo sprintf('%0.2f',$total); ?> €'
            },{
                value: <?php echo $per_not_invoiced; ?>,
                label: 'Non facturés'
            },  {
                value: <?php echo $per_proforma ?>,
                label: 'Proforma <?php echo $total_hour_proforma; ?>'
            }],
            resize: true,
            backgroundColor: '#ffffff',
            labelColor: '#999999',
            colors: [
				'#d4a016',
                '#D43C64',
				'#9972B5'
               
                
            ],
            formatter: function(x) {
                return x + "%"
            }
        });
		

    };






    /******************************
     initialize respective scripts 
     *****************************/
    $(document).ready(function() {
        ULTRA_SETTINGS.chartMorris();
    });

    $(window).resize(function() {});

    $(window).load(function() {});

});
</script>