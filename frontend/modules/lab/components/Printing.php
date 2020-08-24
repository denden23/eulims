<?php



namespace frontend\modules\lab\components;

use kartik\mpdf\Pdf;
use common\models\system\RstlDetails;
use common\components\Functions;
use rmrevin\yii\fontawesome\FA;
use common\models\lab\Sample;
use common\models\lab\Request;
use common\models\lab\Analysis;
use common\models\lab\LabManager;
use common\models\finance\Paymentitem;
use common\models\finance\Receipt;
/**
 * Description of RequestPrinting
 *
 * @author OneLab
 */
class Printing {


    public function actionPrintCsi(){
        $Func = new Functions();
        $Proc = "spGetRequestService(:nRequestID)";
        $Params = [':nRequestID' => $id];
        $Connection = \Yii::$app->labdb;
        $RequestRows = $Func->ExecuteStoredProcedureRows($Proc, $Params, $Connection);
        $RequestHeader = (object) $RequestRows[0];
        $rstl_id = $RequestHeader->rstl_id;
        $RstlDetails = RstlDetails::find()->where(['rstl_id' => $rstl_id])->one();
        $border=0;//Border for adjustments
        if ($RstlDetails) {
            $RequestTemplate = "<table border='$border' style='font-size: 8px' width=100%>";
            $RequestTemplate .= "<thead><tr><td colspan='7' style='height: 110px;text-align: center'>&nbsp;</td></tr></thead>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td style='width: 50px;height: 15px'>&nbsp;</td>";
            $RequestTemplate .= "<td style='width: 50px'>&nbsp;</td>";
            $RequestTemplate .= "<td style='width: 190px'>&nbsp;</td>";
            $RequestTemplate .= "<td style='width: 170px'>&nbsp;</td>";
            $RequestTemplate .= "<td style='width: 85px'>&nbsp;</td>";
            $RequestTemplate .= "<td style='width: 85px'>&nbsp;</td>";
            $RequestTemplate .= "<td>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='2'>&nbsp;</td>";
            $RequestTemplate .= "<td>Nolan Sunico</td>";
            $RequestTemplate .= "<td colspan='3'>&nbsp;</td>";
            $RequestTemplate .= "<td style='padding-left: 10px'>12345</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='2'>&nbsp;</td>";
            $RequestTemplate .= "<td>Recodo Zamboanga City</td>";
            $RequestTemplate .= "<td colspan='3'>&nbsp;</td>";
            $RequestTemplate .= "<td style='padding-left: 10px'>11/14/2018</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='2'>&nbsp;</td>";
            $RequestTemplate .= "<td>Tel Fax #</td>";
            $RequestTemplate .= "<td colspan='3'>&nbsp;</td>";
            $RequestTemplate .= "<td style='padding-left: 10px'>PR #/PO #</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='2'>&nbsp;</td>";
            $RequestTemplate .= "<td>Project Name</td>";
            $RequestTemplate .= "<td colspan='3'>&nbsp;</td>";
            $RequestTemplate .= "<td style='padding-left: 10px'>TIN #</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='2'>&nbsp;</td>";
            $RequestTemplate .= "<td>Address 2</td>";
            $RequestTemplate .= "<td colspan='3'>&nbsp;</td>";
            $RequestTemplate .= "<td>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='2'>&nbsp;</td>";
            $RequestTemplate .= "<td>Tel Fax 2</td>";
            $RequestTemplate .= "<td colspan='3'>&nbsp;</td>";
            $RequestTemplate .= "<td>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='2'>&nbsp;</td>";
            $RequestTemplate .= "<td>Email Address</td>";
            $RequestTemplate .= "<td colspan='3'>&nbsp;</td>";
            $RequestTemplate .= "<td>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr><td colspan='7' style='height: 45px;text-align: center'>&nbsp;</td></tr>";
            $CounterLimit=12;
            for($counter=1;$counter<=$CounterLimit;$counter++){
                $RequestTemplate .= "<tr>";
                $RequestTemplate .= "<td style='text-align: center;height: 23px'>23</td>";
                $RequestTemplate .= "<td colspan='2'>Sample Description</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>Sample Code</td>";
                $RequestTemplate .= "<td colspan='2'>Analysis/Sampling Method</td>";
                $RequestTemplate .= "<td style='text-align: right;padding-right: 10px'>11234.00</td>";
                $RequestTemplate .= "</tr>";
            }
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='4'>&nbsp;</td>";
            $RequestTemplate .= "<td>&nbsp;</td>";
            $RequestTemplate .= "<td>&nbsp;</td>";
            $RequestTemplate .= "<td valign='bottom' style='text-align: right;padding-right: 10px;height: 15px'>tot.am</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='4' style='height: 10px;font-size: 7px;font-weight: bold'>";
            $RequestTemplate .= "<i class='fa fa-check'>/</i>";
            $RequestTemplate .= "</td>";
            $RequestTemplate .= "<td></td>";
            $RequestTemplate .= "<td></td>";
            $RequestTemplate .= "<td></td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='4'>&nbsp;</td>";
            $RequestTemplate .= "<td>&nbsp;</td>";
            $RequestTemplate .= "<td>&nbsp;</td>";
            $RequestTemplate .= "<td style='text-align: right;padding-right: 10px'>vat.am</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='2'>&nbsp;</td>";
            $RequestTemplate .= "<td style='text-align: left;padding-left: 50px'>CRO</td>";
            $RequestTemplate .= "<td style='text-align: right;padding-right: 10px'>11/14/2018 04:32 PM</td>";
            $RequestTemplate .= "<td>&nbsp;</td>";
            $RequestTemplate .= "<td></td>";
            $RequestTemplate .= "<td style='text-align: right;padding-right: 10px'></td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='4'>&nbsp;</td>";
            $RequestTemplate .= "<td colspan='2'>&nbsp;</td>";
            $RequestTemplate .= "<td valign='top' style='text-align: right;padding-right: 10px'>tot.pa</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='6' valign='top' style='padding-top: 30px' rowspan='2'>Special Instructions</td>";
            $RequestTemplate .= "<td style='text-align: right;padding-right: 10px;height: 25px'>Deposit O.R</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td style='text-align: right;padding-right: 10px;height: 25px'>Bal.00</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='7' style='padding-left: 5px;height: 25px'>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='7' style='padding-left: 5px'>This is my Remarks</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='7'>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "</table>";
            $RequestTemplate .= "<table border='$border' style='border-collapse: collapse;font-size: 12px' width=100%>";
            $RequestTemplate .= "<tr><td colspan='4' style='height: 50px;text-align: center'>&nbsp;</td></tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td style='padding-left: 10px'>Printed Name and Signature</td>";
            $RequestTemplate .= "<td style='padding-left: 10px'>Date and Time</td>";
            $RequestTemplate .= "<td style='padding-left: 10px'>Printed Name and Signature</td>";
            $RequestTemplate .= "<td style='padding-left: 10px'>Date and Time</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr><td colspan='4' style='height: 50px;text-align: center'>&nbsp;</td></tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td style='padding-left: 10px'>Printed Name and Signature</td>";
            $RequestTemplate .= "<td style='padding-left: 10px'>Date and Time</td>";
            $RequestTemplate .= "<td style='padding-left: 10px'>Printed Name and Signature</td>";
            $RequestTemplate .= "<td style='padding-left: 10px'>Date and Time</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "</table>";
        }
        return $RequestTemplate;
     
    
      }
    public function PrintRequest($id) {
        
        \Yii::$app->view->registerJsFile("css/pdf.css");
        $config= \Yii::$app->components['reports'];
        $ReportNumber=(int)$config['ReportNumber'];
       
        if($ReportNumber==1){
             $mTemplate = $this->RequestTemplate($id);
        }elseif($ReportNumber==2){
            $mTemplate=$this->FastReport($id);
        }else{// in case does not matched any
            $mTemplate="<div class='col-md-12 danger'><h3>Report Configuration is not properly set.</h3></div>";
        }
        $pdfFooter = [
            'L' => [
                'content' => '',
                'font-size' => 0,
                'font-style' => 'B',
                'color' => '#999999',
            ],
            'C' => [
                'content' => '{PAGENO}',
                'font-size' => 10,
                'font-style' => 'B',
                'font-family' => 'arial',
                'color' => '#333333',
            ],
            'R' => [
                'content' => '',
                'font-size' => 0,
                'font-style' => 'B',
                'font-family' => 'arial',
                'color' => '#333333',
            ],
            'line' => false,
        ];
        $mPDF = new Pdf(['cssFile' => 'css/pdf.css']);
        //$html = mb_convert_encoding($mTemplate, 'UTF-8', 'UTF-8');
        //$mPDF=$PDF->api;
        $mPDF->content = $mTemplate;
        $mPDF->orientation = Pdf::ORIENT_PORTRAIT;
        $mPDF->defaultFontSize = 8;
        $mPDF->defaultFont = 'Arial';
        $mPDF->format =Pdf::FORMAT_A4;
        $mPDF->destination = Pdf::DEST_BROWSER;
        $mPDF->methods =['SetFooter'=>['|{PAGENO}|']];
       // $mPDF->SetDirectionality='rtl';
        $mPDF->render();
        exit;
    }
    public function PrintReportcsi($id) {
        
        \Yii::$app->view->registerJsFile("css/csi_styles.css");
      
        $mPDF = new Pdf(['cssFile' => 'css/csi_styles.css']);
          
        $csi = '<body>
        <div class="header">
          <p><strong>Customer Satisfaction Measurement Report</strong></p>
          <p><span>For the month of June 2019</span></p>
        </div>
        <div class="content">
          <table>
            <tbody>
              <tr>
                <td colspan="2">
                  <strong >I. Information</strong>
                </td>
              </tr>
              <tr>
                <td >No. of Customers</td>
                <td>
                  <!-- NUMBER OF CUSTOMERS -->
                  <strong>24</strong>
                </td>
              </tr>
              <tr>
                <td>Type of Industry</td>
                <td>
                  <ul>
                    <!-- LOOP THROUGH EACH TYPE OF INDUSTRIES -->
                    <li>3 Academe</li>
                    <li>7 Canned/Bottled Fish</li>
                    <li>1 Seaweeds</li>
                    <li>5 Petroleum products/haulers</li>
                    <li>3 Marine Products</li>
                    <li>3 Fishmeal</li>
                    <li>1 Rubber</li>
                    <li>2 Hospital</li>
                    <li>6 Others</li>
                  </ul>
                </td>
              </tr>
              <tr>
                <td>Type of market</td>
                <td>
                  <ul>
                    <!-- LOOP THROUGH EACH TYPE OF MARKET -->
                    <li>Local - 19</li>
                    <li>Export - 3</li>
                    <li>Both - 3</li>
                  </ul>
                </td>
              </tr>
              <tr>
                <td>
                  <strong>II. Delivery of Service</strong>
                </td>
                <td>
                  <table style="table-layout: fixed;">
                    <thead>
                      <tr>
                        <th>TOTAL SCORE</th>
                        <th>Importance Score</th>
                        <th>WF</th>
                        <th>Satisfaction Score</th>
                        <th>Weighted Score</th>
                      </tr>
                    </thead>
                    <tbody class="delivery-of-service">
                      <tr>
                        <td colspan="5">
                          <strong>Delivery Time</strong>
                        </td>
                      </tr>
                      <tr>
                        <td>0</td><!-- : TOTAL SCORE -->
                        <td>0</td><!-- : Importance Score -->
                        <td>0</td><!-- : WF -->
                        <td>0</td><!-- : Satisfaction Score -->
                        <td>0</td><!-- : Weighted Score -->
                      </tr>
                      <tr>
                        <td colspan="5">
                          <strong>Correctness and accuracy of test results</strong>
                        </td>
                      </tr>
                      <tr>
                        <td>0</td><!-- Delivery Time: TOTAL SCORE -->
                        <td>0</td><!-- Delivery Time: Importance Score -->
                        <td>0</td><!-- Delivery Time: WF -->
                        <td>0</td><!-- Delivery Time: Satisfaction Score -->
                        <td>0</td><!-- Delivery Time: Weighted Score -->
                      </tr>
                      <tr>
                        <td colspan="5">
                          <strong>Speed of service</strong>
                        </td>
                      </tr>
                      <tr>
                        <td>0</td><!-- Speed of Service: TOTAL SCORE -->
                        <td>0</td><!-- Speed of Service: Importance Score -->
                        <td>0</td><!-- Speed of Service: WF -->
                        <td>0</td><!-- Speed of Service: Satisfaction Score -->
                        <td>0</td><!-- Speed of Service: Weighted Score -->
                      </tr>
                      <tr>
                        <td colspan="5">
                          <strong>Cost</strong>
                        </td>
                      </tr>
                      <tr>
                        <td>0</td><!-- Cost: TOTAL SCORE -->
                        <td>0</td><!-- Cost: Importance Score -->
                        <td>0</td><!-- Cost: WF -->
                        <td>0</td><!-- Cost: Satisfaction Score -->
                        <td>0</td><!-- Cost: Weighted Score -->
                      </tr>
                      <tr>
                        <td colspan="5">
                          <strong>Attitude of staff</strong>
                        </td>
                      </tr>
                      <tr>
                        <td>0</td><!-- Attitude of Staff: TOTAL SCORE -->
                        <td>0</td><!-- Attitude of Staff: Importance Score -->
                        <td>0</td><!-- Attitude of Staff: WF -->
                        <td>0</td><!-- Attitude of Staff: Satisfaction Score -->
                        <td>0</td><!-- Attitude of Staff: Weighted Score -->
                      </tr>
                      <tr>
                        <td></td>
                        <td>0</td><!-- Total Importance Score  -->
                        <td>0</td><!-- Total WF -->
                        <td></td>
                        <td>0</td><!-- Total Weighted Score -->
                      </tr>
                      <tr class="highlight">
                        <td colspan="4">
                          <strong>SATISFACTION INDEX:</strong>
                        </td>
                        <td>0</td><!-- SATISFACTION INDEX -->
                      </tr>
                      <tr class="highlight">
                        <td colspan="4">
                          <strong>OVER-ALL CUSTOMER EXPERIENCE:</strong>
                        </td>
                        <td>0</td><!-- OVER-ALL CUSTOMER EXPERIENCE -->
                      </tr>
                      <tr class="highlight">
                        <td colspan="4">
                          <strong>NET PROMOTER SCORE:</strong>
                        </td>
                        <td>0</td><!-- NET PROMOTER SCORE -->
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
              <tr>
                <td>
                  <strong>III. Comments/Suggestions</strong>
                </td>
                <td>
                  <ol>
                    <!-- LOOP THROUGH EACH COMMENT -->
                
                  </ol>
                </td>
              </tr>
              <tr>
                <td>
                  <strong>IV. Actions</strong>
                </td>
                <td></td><!-- ACTIONS TAKEN -->
              </tr>
            </tbody>
          </table>
        </div>
        <div class="footer">
          <div></div>
          <div></div>
          <div>
            <p>Processed by:</p>
            <div>
              <strong>ROSEMARIE S. SALAZAR</strong>
              <p>Quality Manager</p>
            </div>
          </div>
        </div>
      </body>';
        $mPDF->content = $csi;
        $mPDF->orientation = Pdf::ORIENT_PORTRAIT;
      //  $mPDF->defaultFontSize = 80;
      //  $mPDF->defaultFont = 'Arial';
        $mPDF->format =Pdf::FORMAT_A4;
        $mPDF->destination = Pdf::DEST_BROWSER;
      //  $mPDF->methods =['SetFooter'=>['|{PAGENO}|']];
        $mPDF->render();
        exit;
    }

    public function PrintReportmonthly($id) {
        
      \Yii::$app->view->registerJsFile("css/monthly.css");
    
      $mPDF = new Pdf(['cssFile' => 'css/monthly.css']);
        
      $csi = '<body>
      <div class="header">
        <p><strong>Customer Satisfaction Feedback</strong></p>
        <p><span>DOST Regional Office No. IX</span></p>
        <br />
      </div>
      <div class="content">
        <table>
          <thead>
            <tr>
              <th colspan="2">Technical Services: Regional Standards and Testing Laboratories</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td style="width: 25%;">For the period:</td>
              <td>June 2019</td><!-- PERIOD DATE-->
            </tr>
            <tr>
              <td style="width: 25%;">Total no. of Respondents:</td>
              <td>24</td><!-- No. of Respondents -->
            </tr>
          </tbody>
        </table>
        <br />
    
        <!-- PART I -->
        <table>
          <tbody>
            <tr>
              <th colspan="14">PART I: Customer Rating of Service Quality</th>
            </tr>
            <tr>
              <th>Service Quality Items</th>
              <th class="font-small">Very Satisfied</th>
              <th class="bg-grey">5</th>
              <th class="font-small">Quite Satisfied</th>
              <th class="bg-grey">4</th>
              <th class="font-small">N Sat nor D Sat</th>
              <th class="bg-grey">3</th>
              <th class="font-small">Quite Dissatisfied</th>
              <th class="bg-grey">2</th>
              <th class="font-small">Very Dissatisfied</th>
              <th class="bg-grey">1</th>
              <th class="font-small">Total Score</th>
              <th>SS</th>
              <th>GAP</th>
            </tr>
            <tr>
              <td>Delivery Time</td>
              <td>21</td><!-- Very Satisfied -->
              <td class="bg-grey color">105</td><!-- 5 -->
              <td>3</td><!-- Quite Satisfied -->
              <td class="bg-grey color">12</td><!-- 4 -->
              <td>0</td><!-- N Sat nor D Sat -->
              <td class="bg-grey color">0</td><!-- 3 -->
              <td>0</td><!-- Quite Dissatisfied -->
              <td class="bg-grey color">0</td><!-- 2 -->
              <td>0</td><!-- Very Dissatisfied -->
              <td class="bg-grey color">0</td><!-- 1 -->
              <td class="color">117</td><!-- TOTAL SCORE -->
              <td class="color2">4.87</td><!-- SS -->
              <td>0.04</td><!-- GAP -->
            </tr>
            <tr>
              <td>Correctness and Accuracy of Results</td>
              <td>22</td><!-- Very Satisfied -->
              <td class="bg-grey color">110</td><!-- 5 -->
              <td>2</td><!-- Quite Satisfied -->
              <td class="bg-grey color">8</td><!-- 4 -->
              <td>0</td><!-- N Sat nor D Sat -->
              <td class="bg-grey color">0</td><!-- 3 -->
              <td>0</td><!-- Quite Dissatisfied -->
              <td class="bg-grey color">0</td><!-- 2 -->
              <td>0</td><!-- Very Dissatisfied -->
              <td class="bg-grey color">0</td><!-- 1 -->
              <td class="color">118</td><!-- TOTAL SCORE -->
              <td class="color2">4.92</td><!-- SS -->
              <td>0.00</td><!-- GAP -->
            </tr>
            <tr>
              <td>Speed of Service</td>
              <td>21</td><!-- Very Satisfied -->
              <td class="bg-grey color">105</td><!-- 5 -->
              <td>3</td><!-- Quite Satisfied -->
              <td class="bg-grey color">12</td><!-- 4 -->
              <td>0</td><!-- N Sat nor D Sat -->
              <td class="bg-grey color">0</td><!-- 3 -->
              <td>0</td><!-- Quite Dissatisfied -->
              <td class="bg-grey color">0</td><!-- 2 -->
              <td>0</td><!-- Very Dissatisfied -->
              <td class="bg-grey color">0</td><!-- 1 -->
              <td class="color">117</td><!-- TOTAL SCORE -->
              <td class="color2">4.88</td><!-- SS -->
              <td>0.04</td><!-- GAP -->
            </tr>
            <tr>
              <td>Cost</td>
              <td>21</td><!-- Very Satisfied -->
              <td class="bg-grey color">105</td><!-- 5 -->
              <td>3</td><!-- Quite Satisfied -->
              <td class="bg-grey color">12</td><!-- 4 -->
              <td>0</td><!-- N Sat nor D Sat -->
              <td class="bg-grey color">0</td><!-- 3 -->
              <td>0</td><!-- Quite Dissatisfied -->
              <td class="bg-grey color">0</td><!-- 2 -->
              <td>0</td><!-- Very Dissatisfied -->
              <td class="bg-grey color">0</td><!-- 1 -->
              <td class="color">117</td><!-- TOTAL SCORE -->
              <td class="color2">4.88</td><!-- SS -->
              <td>0.04</td><!-- GAP -->
            </tr>
            <tr>
              <td>Attitude of Staff</td>
              <td>22</td><!-- Very Satisfied -->
              <td class="bg-grey color">110</td><!-- 5 -->
              <td>2</td><!-- Quite Satisfied -->
              <td class="bg-grey color">8</td><!-- 4 -->
              <td>0</td><!-- N Sat nor D Sat -->
              <td class="bg-grey color">0</td><!-- 3 -->
              <td>0</td><!-- Quite Dissatisfied -->
              <td class="bg-grey color">0</td><!-- 2 -->
              <td>0</td><!-- Very Dissatisfied -->
              <td class="bg-grey color">0</td><!-- 1 -->
              <td class="color">118</td><!-- TOTAL SCORE -->
              <td class="color2">4.92</td><!-- SS -->
              <td>0.00</td><!-- GAP -->
            </tr>
            <tr>
              <td>Over-all Customer Experience</td>
              <td>21</td><!-- Very Satisfied -->
              <td class="bg-grey color">87.50</td><!-- 5 -->
              <td>3</td><!-- Quite Satisfied -->
              <td class="bg-grey color">12.50</td><!-- 4 -->
              <td>0</td><!-- N Sat nor D Sat -->
              <td class="bg-grey color">0</td><!-- 3 -->
              <td>0</td><!-- Quite Dissatisfied -->
              <td class="bg-grey color">0</td><!-- 2 -->
              <td>0</td><!-- Very Dissatisfied -->
              <td class="bg-grey color">0</td><!-- 1 -->
              <td class="color">100</td><!-- TOTAL SCORE -->
              <td></td>
              <td></td>
            </tr>
          </tbody>
        </table>
        <br />
    
        <!-- PART II -->
        <table>
          <thead>
            <tr>
              <th colspan="16">PART II: Importance of these Attributes to the Customers</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th>Importance of Service Quality Attributes to Customers</th>
              <th class="font-small">Very Important</th>
              <th class="bg-grey">5</th>
              <th class="font-small">Quite Important</th>
              <th class="bg-grey">4</th>
              <th class="font-small">Neither Imp nor Unimp</th>
              <th class="bg-grey">3</th>
              <th class="font-small">Quite Unimportant</th>
              <th class="bg-grey">2</th>
              <th class="font-small">Not Important at All</th>
              <th class="bg-grey">1</th>
              <th class="font-small">TOTAL SCORE</th>
              <th>IS</th>
              <th>WF</th>
              <th>SS</th>
              <th>WS</th>
            </tr>
            <tr>
              <td>Delivery Time</td>
              <td>22</td><!-- Very Important -->
              <td class="bg-grey color">110</td><!-- 5 -->
              <td>2</td><!-- Quite Important -->
              <td class="bg-grey color">8</td><!-- 4 -->
              <td>0</td><!-- Neither Imp no Unimp -->
              <td class="bg-grey color">0</td><!-- 3 -->
              <td>0</td><!-- Quite Unimportant -->
              <td class="bg-grey color">0</td><!-- 2 -->
              <td>0</td><!-- Not Important at all -->
              <td class="bg-grey color">0</td><!-- 1 -->
              <td class="color">118</td><!-- TOTAL SCORE -->
              <td class="color2">4.92</td><!-- IS -->
              <td>20.00</td><!-- WF -->
              <td>4.88</td><!-- SS -->
              <td>0.98</td><!-- WS -->
            </tr>
            <tr>
              <td>Correctness and Accuracy of Results</td>
              <td>22</td><!-- Very Important -->
              <td class="bg-grey color">110</td><!-- 5 -->
              <td>2</td><!-- Quite Important -->
              <td class="bg-grey color">8</td><!-- 4 -->
              <td>0</td><!-- Neither Imp no Unimp -->
              <td class="bg-grey color">0</td><!-- 3 -->
              <td>0</td><!-- Quite Unimportant -->
              <td class="bg-grey color">0</td><!-- 2 -->
              <td>0</td><!-- Not Important at all -->
              <td class="bg-grey color">0</td><!-- 1 -->
              <td class="color">118</td><!-- TOTAL SCORE -->
              <td class="color2">4.92</td><!-- IS -->
              <td>20.00</td><!-- WF -->
              <td>4.92</td><!-- SS -->
              <td>0.98</td><!-- WS -->
            </tr>
            <tr>
              <td>Speed of Delivery</td>
              <td>22</td><!-- Very Important -->
              <td class="bg-grey color">110</td><!-- 5 -->
              <td>2</td><!-- Quite Important -->
              <td class="bg-grey color">8</td><!-- 4 -->
              <td>0</td><!-- Neither Imp no Unimp -->
              <td class="bg-grey color">0</td><!-- 3 -->
              <td>0</td><!-- Quite Unimportant -->
              <td class="bg-grey color">0</td><!-- 2 -->
              <td>0</td><!-- Not Important at all -->
              <td class="bg-grey color">0</td><!-- 1 -->
              <td class="color">118</td><!-- TOTAL SCORE -->
              <td class="color2">4.92</td><!-- IS -->
              <td>20.00</td><!-- WF -->
              <td>4.88</td><!-- SS -->
              <td>0.98</td><!-- WS -->
            </tr>
            <tr>
              <td>Cost</td>
              <td>22</td><!-- Very Important -->
              <td class="bg-grey color">110</td><!-- 5 -->
              <td>2</td><!-- Quite Important -->
              <td class="bg-grey color">8</td><!-- 4 -->
              <td>0</td><!-- Neither Imp no Unimp -->
              <td class="bg-grey color">0</td><!-- 3 -->
              <td>0</td><!-- Quite Unimportant -->
              <td class="bg-grey color">0</td><!-- 2 -->
              <td>0</td><!-- Not Important at all -->
              <td class="bg-grey color">0</td><!-- 1 -->
              <td class="color">118</td><!-- TOTAL SCORE -->
              <td class="color2">4.92</td><!-- IS -->
              <td>20.00</td><!-- WF -->
              <td>4.88</td><!-- SS -->
              <td>0.98</td><!-- WS -->
            </tr>
            <tr>
              <td>Attitude of Staff</td>
              <td>22</td><!-- Very Important -->
              <td class="bg-grey color">110</td><!-- 5 -->
              <td>2</td><!-- Quite Important -->
              <td class="bg-grey color">8</td><!-- 4 -->
              <td>0</td><!-- Neither Imp no Unimp -->
              <td class="bg-grey color">0</td><!-- 3 -->
              <td>0</td><!-- Quite Unimportant -->
              <td class="bg-grey color">0</td><!-- 2 -->
              <td>0</td><!-- Not Important at all -->
              <td class="bg-grey color">0</td><!-- 1 -->
              <td class="color">118</td><!-- TOTAL SCORE -->
              <td class="color2">4.92</td><!-- IS -->
              <td>20.00</td><!-- WF -->
              <td>4.92</td><!-- SS -->
              <td>0.98</td><!-- WS -->
            </tr>
            <tr>
              <td colspan="12"></td>
              <td>24.58</td><!-- TOTAL IS -->
              <td>80.00</td><!-- TOTAL WF -->
              <td></td>
              <td>4.89</td><!-- TOTAL WS  -->
            </tr>
            <tr class="highlight">
              <td colspan="15" style="text-align: right;">
                <strong>SATISFACTION INDEX:</strong>
              </td>
              <td>97.83</td><!-- SATISFACTION INDEX -->
            </tr>
          </tbody>
        </table>
        <br />
    
       
        
        </div>
        <br />
    
        <table style="table-layout: fixed;">
          <thead>
            <tr>
              <th>Detractors (0-6)</th>
              <th>Passives (7-8)</th>
              <th>Promoters(9-10)</th>
              <th>Net Promoter Score</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>0</td>
              <td>1</td>
              <td>7</td>
              <td>87.5</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="footer"></div>
    </body>';
      $mPDF->content = $csi;
      $mPDF->orientation = Pdf::ORIENT_PORTRAIT;
    //  $mPDF->defaultFontSize = 80;
    //  $mPDF->defaultFont = 'Arial';
      $mPDF->format =Pdf::FORMAT_A4;
      $mPDF->destination = Pdf::DEST_BROWSER;
    //  $mPDF->methods =['SetFooter'=>['|{PAGENO}|']];
      $mPDF->render();
      exit;
  }

  public function PrintReportdaily($id) {
        
    \Yii::$app->view->registerJsFile("css/day.css");
  
    $mPDF = new Pdf(['cssFile' => 'css/day.css']);
      
    $csi = '<body>
    <div class="header">
      <p>Department of Science and Technology</p>
      <p>REGIONAL STANDARDS AND TESTING LABORATORIES</p>
      <p>Pettit barracks, Zamboanga City</p>
      <p>TEl. No. (63) (62) 991-1024; Fax No. (63) (62) 992-1114</p>
    </div>
    <div class="content">
      <h1>Customer Satisfaction Feedback Survey</h1>
      <br />
  
      <h2>I. Information</h2>
      <table>
        <tbody>
          <tr>
            <td>
              Customer Name: <strong></strong><!-- Customer Name -->
            </td>
          </tr>
          <tr>
            <td>
              Nature of Business:
              <div class="checkbox">
                <div>
                  <div><input type="checkbox" name="" id=""> Raw and processed food</div>
                  <div><input type="checkbox" name="" id=""> Marine products</div>
                  <div><input type="checkbox" name="" id=""> Canned/Bottled Fish</div>
                  <div><input type="checkbox" name="" id=""> Fishmeal</div>
                  <div><input type="checkbox" name="" id=""> Seaweeds</div>
                </div>
                <div>
                  <div><input type="checkbox" name="" id=""> Petroleum Products/Haulers</div>
                  <div><input type="checkbox" name="" id=""> Mining</div>
                  <div><input type="checkbox" name="" id=""> Hospitals</div>
                  <div><input type="checkbox" name="" id=""> Academe/Students</div>
                  <div><input type="checkbox" name="" id=""> Beverage and juices</div>
                </div>
                <div>
                  <div><input type="checkbox" name="" id=""> Government/LGUs</div>
                  <div><input type="checkbox" name="" id=""> Construction</div>
                  <div><input type="checkbox" name="" id=""> Water Refilling/Bottled Water</div>
                  <div><input type="checkbox" name="" id=""> Others</div>
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td>
              Type of Market:
              <div class="checkbox">
                <div>
                  <div><input type="checkbox" name="" id=""> Local</div>
                </div>
                <div>
                  <div><input type="checkbox" name="" id=""> Export</div>
                </div>
                <div>
                  <div><input type="checkbox" name="" id=""> Both</div>
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td>
              What services of the RSTL have you availed?
              <div class="checkbox">
                <div>
                  <div><input type="checkbox" name="" id=""> Microbiological Testing</div>
                </div>
                <div>
                  <div><input type="checkbox" name="" id=""> Chemical Testing</div>
                </div>
                <div>
                  <div><input type="checkbox" name="" id=""> Calibration</div>
                </div>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
      <br />
  
      <h2>II. Delivery of Service</h2>
      <table class="custom-table">
        <thead>
          <tr>
            <th>Service Quality Items</th>
            <th>Very Satisfied (5)</th>
            <th>Quite Satisfied (4)</th>
            <th>Neither satisfied nor Dissatisfied (3)</th>
            <th>Quite Dissatisfied (2)</th>
            <th>Very Dissatisfied (1)</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Delivery Time</td>
            <td><input type="checkbox" name="" id=""></td><!-- 5 -->
            <td><input type="checkbox" name="" id=""></td><!-- 4 -->
            <td><input type="checkbox" name="" id=""></td><!-- 3 -->
            <td><input type="checkbox" name="" id=""></td><!-- 2 -->
            <td><input type="checkbox" name="" id=""></td><!-- 1 -->
          </tr>
          <tr>
            <td>Correctness and accuracy of test results</td>
            <td><input type="checkbox" name="" id=""></td><!-- 5 -->
            <td><input type="checkbox" name="" id=""></td><!-- 4 -->
            <td><input type="checkbox" name="" id=""></td><!-- 3 -->
            <td><input type="checkbox" name="" id=""></td><!-- 2 -->
            <td><input type="checkbox" name="" id=""></td><!-- 1 -->
          </tr>
          <tr>
            <td>Speed of service</td>
            <td><input type="checkbox" name="" id=""></td><!-- 5 -->
            <td><input type="checkbox" name="" id=""></td><!-- 4 -->
            <td><input type="checkbox" name="" id=""></td><!-- 3 -->
            <td><input type="checkbox" name="" id=""></td><!-- 2 -->
            <td><input type="checkbox" name="" id=""></td><!-- 1 -->
          </tr>
          <tr>
            <td>Cost</td>
            <td><input type="checkbox" name="" id=""></td><!-- 5 -->
            <td><input type="checkbox" name="" id=""></td><!-- 4 -->
            <td><input type="checkbox" name="" id=""></td><!-- 3 -->
            <td><input type="checkbox" name="" id=""></td><!-- 2 -->
            <td><input type="checkbox" name="" id=""></td><!-- 1 -->
          </tr>
          <tr>
            <td>Attitude of staff</td>
            <td><input type="checkbox" name="" id=""></td><!-- 5 -->
            <td><input type="checkbox" name="" id=""></td><!-- 4 -->
            <td><input type="checkbox" name="" id=""></td><!-- 3 -->
            <td><input type="checkbox" name="" id=""></td><!-- 2 -->
            <td><input type="checkbox" name="" id=""></td><!-- 1 -->
          </tr>
          <tr>
            <td>Over-all customer experience</td>
            <td><input type="checkbox" name="" id=""></td><!-- 5 -->
            <td><input type="checkbox" name="" id=""></td><!-- 4 -->
            <td><input type="checkbox" name="" id=""></td><!-- 3 -->
            <td><input type="checkbox" name="" id=""></td><!-- 2 -->
            <td><input type="checkbox" name="" id=""></td><!-- 1 -->
          </tr>
        </tbody>
      </table>
      <br />
  
      <h2>III. How <span>important</span> are these items to you?</h2>
      <table class="custom-table">
        <thead>
          <tr>
            <th>Service Quality Items</th>
            <th>Very important (5)</th>
            <th>Quite important (4)</th>
            <th>Neither important nor unimportant (3)</th>
            <th>Quite unimportant (2)</th>
            <th>Not at all important (1)</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Delivery Time</td>
            <td><input type="checkbox" name="" id=""></td>
            <td><input type="checkbox" name="" id=""></td>
            <td><input type="checkbox" name="" id=""></td>
            <td><input type="checkbox" name="" id=""></td>
            <td><input type="checkbox" name="" id=""></td>
          </tr>
          <tr>
            <td>Correctness and accuracy of test results</td>
            <td><input type="checkbox" name="" id=""></td>
            <td><input type="checkbox" name="" id=""></td>
            <td><input type="checkbox" name="" id=""></td>
            <td><input type="checkbox" name="" id=""></td>
            <td><input type="checkbox" name="" id=""></td>
          </tr>
          <tr>
            <td>Speed of service</td>
            <td><input type="checkbox" name="" id=""></td>
            <td><input type="checkbox" name="" id=""></td>
            <td><input type="checkbox" name="" id=""></td>
            <td><input type="checkbox" name="" id=""></td>
            <td><input type="checkbox" name="" id=""></td>
          </tr>
          <tr>
            <td>Cost</td>
            <td><input type="checkbox" name="" id=""></td>
            <td><input type="checkbox" name="" id=""></td>
            <td><input type="checkbox" name="" id=""></td>
            <td><input type="checkbox" name="" id=""></td>
            <td><input type="checkbox" name="" id=""></td>
          </tr>
          <tr>
            <td>Attitude of staff</td>
            <td><input type="checkbox" name="" id=""></td>
            <td><input type="checkbox" name="" id=""></td>
            <td><input type="checkbox" name="" id=""></td>
            <td><input type="checkbox" name="" id=""></td>
            <td><input type="checkbox" name="" id=""></td>
          </tr>
          <tr>
            <td>Over-all customer experience</td>
            <td><input type="checkbox" name="" id=""></td>
            <td><input type="checkbox" name="" id=""></td>
            <td><input type="checkbox" name="" id=""></td>
            <td><input type="checkbox" name="" id=""></td>
            <td><input type="checkbox" name="" id=""></td>
          </tr>
        </tbody>
      </table>
      <br />
  
      <h2>IV. How likely is it that you would <span>recommend</span> our service to others?</h2>
      <table style="table-layout: fixed;" class="thtd-center">
        <thead>
          <tr>
            <th>0<br /><span style="font-size: smaller;">Not at all likely</span></th>
            <th>1</th>
            <th>2</th>
            <th>3</th>
            <th>4</th>
            <th>5</th>
            <th>6</th>
            <th>7</th>
            <th>8</th>
            <th>9</th>
            <th>10<br /><span style="font-size: smaller;">Extremely likely</span></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><input type="checkbox" name="" id=""></td>
            <td><input type="checkbox" name="" id=""></td>
            <td><input type="checkbox" name="" id=""></td>
            <td><input type="checkbox" name="" id=""></td>
            <td><input type="checkbox" name="" id=""></td>
            <td><input type="checkbox" name="" id=""></td>
            <td><input type="checkbox" name="" id=""></td>
            <td><input type="checkbox" name="" id=""></td>
            <td><input type="checkbox" name="" id=""></td>
            <td><input type="checkbox" name="" id=""></td>
            <td><input type="checkbox" name="" id=""></td>
          </tr>
        </tbody>
      </table>
      <br />
  
      <h2>V. Please give us your comments/suggestions to improve our services. Also, let us know other tests you require that we are not able to provide yet.</h2>
      <hr>
      <hr>
      <hr>
    </div>
    <div class="footer">
      <div class="checkbox" style="margin: 30px 0;">
        <div style="flex: 1; display: flex;">
          Feedback given by:
          <div style="
            flex: 1;
            border-bottom: 1px solid #000;
            margin: 0 10px 0 5px;
            padding: 0 2px;
          ">
           
          </div>
        </div>
        <div style="flex: 1; display: flex;">
          Date:
          <div style="
            flex: 1;
            border-bottom: 1px solid #000;
            margin-left: 5px;
            padding: 0 2px;
          ">
            6-29-19
          </div>
        </div>
      </div>
    </div>
  </body>';
    $mPDF->content = $csi;
    $mPDF->orientation = Pdf::ORIENT_PORTRAIT;
  //  $mPDF->defaultFontSize = 80;
  //  $mPDF->defaultFont = 'Arial';
    $mPDF->format =Pdf::FORMAT_A4;
    $mPDF->destination = Pdf::DEST_BROWSER;
  //  $mPDF->methods =['SetFooter'=>['|{PAGENO}|']];
    $mPDF->render();
    exit;
}

    private function FastReport($id){
        $Func = new Functions();
        $Proc = "spGetRequestService(:nRequestID)";
        $Params = [':nRequestID' => $id];
        $Connection = \Yii::$app->labdb;
        $RequestRows = $Func->ExecuteStoredProcedureRows($Proc, $Params, $Connection);
        $RequestHeader = (object) $RequestRows[0];
        $rstl_id = $RequestHeader->rstl_id;
        $RstlDetails = RstlDetails::find()->where(['rstl_id' => $rstl_id])->one();
        $border=0;//Border for adjustments
        if ($RstlDetails) {
            $RequestTemplate = "<table border='$border' style='font-size: 8px' width=100%>";
            $RequestTemplate .= "<thead><tr><td colspan='7' style='height: 110px;text-align: center'>&nbsp;</td></tr></thead>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td style='width: 50px;height: 15px'>&nbsp;</td>";
            $RequestTemplate .= "<td style='width: 50px'>&nbsp;</td>";
            $RequestTemplate .= "<td style='width: 190px'>&nbsp;</td>";
            $RequestTemplate .= "<td style='width: 170px'>&nbsp;</td>";
            $RequestTemplate .= "<td style='width: 85px'>&nbsp;</td>";
            $RequestTemplate .= "<td style='width: 85px'>&nbsp;</td>";
            $RequestTemplate .= "<td>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='2'>&nbsp;</td>";
            $RequestTemplate .= "<td>Nolan Sunico</td>";
            $RequestTemplate .= "<td colspan='3'>&nbsp;</td>";
            $RequestTemplate .= "<td style='padding-left: 10px'>12345</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='2'>&nbsp;</td>";
            $RequestTemplate .= "<td>Recodo Zamboanga City</td>";
            $RequestTemplate .= "<td colspan='3'>&nbsp;</td>";
            $RequestTemplate .= "<td style='padding-left: 10px'>11/14/2018</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='2'>&nbsp;</td>";
            $RequestTemplate .= "<td>Tel Fax #</td>";
            $RequestTemplate .= "<td colspan='3'>&nbsp;</td>";
            $RequestTemplate .= "<td style='padding-left: 10px'>PR #/PO #</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='2'>&nbsp;</td>";
            $RequestTemplate .= "<td>Project Name</td>";
            $RequestTemplate .= "<td colspan='3'>&nbsp;</td>";
            $RequestTemplate .= "<td style='padding-left: 10px'>TIN #</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='2'>&nbsp;</td>";
            $RequestTemplate .= "<td>Address 2</td>";
            $RequestTemplate .= "<td colspan='3'>&nbsp;</td>";
            $RequestTemplate .= "<td>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='2'>&nbsp;</td>";
            $RequestTemplate .= "<td>Tel Fax 2</td>";
            $RequestTemplate .= "<td colspan='3'>&nbsp;</td>";
            $RequestTemplate .= "<td>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='2'>&nbsp;</td>";
            $RequestTemplate .= "<td>Email Address</td>";
            $RequestTemplate .= "<td colspan='3'>&nbsp;</td>";
            $RequestTemplate .= "<td>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr><td colspan='7' style='height: 45px;text-align: center'>&nbsp;</td></tr>";
            $CounterLimit=12;
            for($counter=1;$counter<=$CounterLimit;$counter++){
                $RequestTemplate .= "<tr>";
                $RequestTemplate .= "<td style='text-align: center;height: 23px'>23</td>";
                $RequestTemplate .= "<td colspan='2'>Sample Description</td>";
                $RequestTemplate .= "<td style='padding-left: 5px'>Sample Code</td>";
                $RequestTemplate .= "<td colspan='2'>Analysis/Sampling Method</td>";
                $RequestTemplate .= "<td style='text-align: right;padding-right: 10px'>11234.00</td>";
                $RequestTemplate .= "</tr>";
            }
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='4'>&nbsp;</td>";
            $RequestTemplate .= "<td>&nbsp;</td>";
            $RequestTemplate .= "<td>&nbsp;</td>";
            $RequestTemplate .= "<td valign='bottom' style='text-align: right;padding-right: 10px;height: 15px'>tot.am</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='4' style='height: 10px;font-size: 7px;font-weight: bold'>";
            $RequestTemplate .= "<i class='fa fa-check'>/</i>";
            $RequestTemplate .= "</td>";
            $RequestTemplate .= "<td></td>";
            $RequestTemplate .= "<td></td>";
            $RequestTemplate .= "<td></td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='4'>&nbsp;</td>";
            $RequestTemplate .= "<td>&nbsp;</td>";
            $RequestTemplate .= "<td>&nbsp;</td>";
            $RequestTemplate .= "<td style='text-align: right;padding-right: 10px'>vat.am</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='2'>&nbsp;</td>";
            $RequestTemplate .= "<td style='text-align: left;padding-left: 50px'>CRO</td>";
            $RequestTemplate .= "<td style='text-align: right;padding-right: 10px'>11/14/2018 04:32 PM</td>";
            $RequestTemplate .= "<td>&nbsp;</td>";
            $RequestTemplate .= "<td></td>";
            $RequestTemplate .= "<td style='text-align: right;padding-right: 10px'></td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='4'>&nbsp;</td>";
            $RequestTemplate .= "<td colspan='2'>&nbsp;</td>";
            $RequestTemplate .= "<td valign='top' style='text-align: right;padding-right: 10px'>tot.pa</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='6' valign='top' style='padding-top: 30px' rowspan='2'>Special Instructions</td>";
            $RequestTemplate .= "<td style='text-align: right;padding-right: 10px;height: 25px'>Deposit O.R</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td style='text-align: right;padding-right: 10px;height: 25px'>Bal.00</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='7' style='padding-left: 5px;height: 25px'>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='7' style='padding-left: 5px'>This is my Remarks</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='7'>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "</table>";
            $RequestTemplate .= "<table border='$border' style='border-collapse: collapse;font-size: 12px' width=100%>";
            $RequestTemplate .= "<tr><td colspan='4' style='height: 50px;text-align: center'>&nbsp;</td></tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td style='padding-left: 10px'>Printed Name and Signature</td>";
            $RequestTemplate .= "<td style='padding-left: 10px'>Date and Time</td>";
            $RequestTemplate .= "<td style='padding-left: 10px'>Printed Name and Signature</td>";
            $RequestTemplate .= "<td style='padding-left: 10px'>Date and Time</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr><td colspan='4' style='height: 50px;text-align: center'>&nbsp;</td></tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td style='padding-left: 10px'>Printed Name and Signature</td>";
            $RequestTemplate .= "<td style='padding-left: 10px'>Date and Time</td>";
            $RequestTemplate .= "<td style='padding-left: 10px'>Printed Name and Signature</td>";
            $RequestTemplate .= "<td style='padding-left: 10px'>Date and Time</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "</table>";
        }
        return $RequestTemplate;
    }

    /*
    Created By: Bergel T. Cutara
    Contacts:

    Email: b.cutara@gmail.com
    Tel. Phone: (062) 991-1024
    Mobile Phone: (639) 956200353

    Description: RequestTemplate function is being used in printing the Request Report
    **/


    private function RequestTemplate($id) {

        $Func = new Functions();
        $Form="OP-007-F1"."<br>"."Rev. 06 | 11.04.19";
        $Connection = \Yii::$app->labdb;
        
        $request = Request::find()->where(['request_id' => $id])->one();
        $completeaddress = $request->customer->completeaddress;
        $totalfee =0;

        
        $rstl_id = $request->rstl_id;
       
        $RstlDetails = RstlDetails::find()->where(['rstl_id' => $rstl_id])->one();
        if ($RstlDetails) {
            $RequestTemplate = "<table border='0' style='border-collapse: collapse;font-size: 11px;table-layout:fixed' width=100%>";
            $RequestTemplate .= "<thead>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='10' style='text-align: center;font-size: 11px'>$RstlDetails->name</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='10' style='text-align: center;font-size: 11px;font-weight: bold'>REGIONAL STANDARDS AND TESTING LABORATORIES</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='10' style='width: 100%;text-align: center;font-size: 11px;word-wrap: break-word'><div style='width: 100px;'>$RstlDetails->address</div></td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='10' style='text-align: center;font-size: 11px'><div style='width: 100px;'>$RstlDetails->contacts</div></td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='10' style='text-align: center;font-size: 11px'>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='10' style='text-align: center;font-weight: bold;font-size: 15px'>Request for " . strtoupper($RstlDetails->shortName) . " RSTL Services</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='10'>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "</thead>";
            $RequestTemplate .= "<tbody>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='2' style='border-top: 1px solid black;border-left: 1px solid black;font-size:10px'>Request Reference No.:</td>";
            $RequestTemplate .= "<td colspan='3' style='border-top: 1px solid black;border-top: 1px solid black;border-right: 1px solid black;text-align: left;color:#0f17c4;font-weight;margin-left-20px'>$request->request_ref_num</td>";
            $RequestTemplate .= "<td colspan='5'>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='2' style='border-left: 1px solid black;border-top: 1px solid black;font-size:11px'>Date :</td>";

            $RequestTemplate .= "<td colspan='3' style='border-top: 1px solid black;border-right: 1px solid black;text-align: left;color:#0f17c4'>" . date('F d, Y', strtotime($request->request_datetime)) . "</td>";
            $RequestTemplate .= "<td colspan='5'>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='2' style='border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;font-size:11px'>Time :</td>";
            $RequestTemplate .= "<td colspan='3' style='border-top: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;text-align: left;color:#0f17c4'>" . date('h:i A', strtotime($request->request_datetime)) . "</td>";
            $RequestTemplate .= "<td colspan='5'>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='10' style='height: 5px'></td>";
            $RequestTemplate .= "</tr>";
            
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td style='border-top: 1px solid black;border-left: 1px solid black'>Customer:</td>";
            $RequestTemplate .= "<td colspan='6' style='color:#0f17c4;border-top: 1px solid black;font-weight:bold'>" . strtoupper($request->customer->customer_name) . "</td>";
            $RequestTemplate .= "<td style='border-top: 1px solid black;border-top: 1px solid black;border-left: 1px solid black;'>Tel No.:</td>";
            $RequestTemplate .= "<td colspan='2' style='color:#0f17c4;border-top: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;'>".$request->customer->tel."</td>";
            $RequestTemplate .= "</tr>";
            
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;'>Address:</td>";
            $RequestTemplate .= "<td colspan='6' style='color:#0f17c4;border-bottom: 1px solid black;border-bottom: 1px solid black;border-top: 1px solid black;'>". $this->sentenceCase($completeaddress)  ."</td>";
            $RequestTemplate .= "<td style='border-bottom: 1px solid black;border-top: 1px solid black;border-left: 1px solid black;'>Fax No.:</td>";
            $RequestTemplate .= "<td colspan='2' style='color:#0f17c4;border-bottom: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;'>".$request->customer->fax."</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr ><td style='height:10px'></td></tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<th colspan='10' class='text-left border-bottom-line'>1. CALIBRATION OR TESTING SERVICE</th>";
            $RequestTemplate .= "</tr>";
            
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<th colspan='2' class='text-center border-center-line border-left-line border-right-line padding-left-5' style=''>Sample</th>";
            $RequestTemplate .= "<th class='text-center border-bottom-line border-right-line padding-left-5' style='width: 10%;'>Sample Code</th>";
            $RequestTemplate .= "<th colspan='2' class='text-center border-bottom-line border-right-line padding-left-5' style='width: 20%;'>Calibration or Test Requested</th>";
            $RequestTemplate .= "<th colspan='2' class='text-center border-bottom-line border-right-line padding-left-5' style='width: 15%;'>Calibration or Test Method</th>";
            $RequestTemplate .= "<th class='text-center border-bottom-line border-right-line padding-left-5' style='width: 9%;'>No. of Samples</th>";
            $RequestTemplate .= "<th class='text-center border-bottom-line border-right-line padding-right-5' style='width: 9%;'>Unit Cost</th>";
            $RequestTemplate .= "<th class='text-center border-bottom-line border-right-line border-right-line padding-right-5' style='width: 11%;'>Total</th>";
            $RequestTemplate .= "</tr>";
            
            $CurSampleCode = "";
            $PrevSampleCode = "";

            $i = 0;
            //loop for everysamples the request has
            foreach ($request->samples as $sample) {
               
               if($sample->active){ //only the active samples are allowed to be printed

                //************************************
                //temporary
                //lab personnel wants to only have 4 digit figure in sample code
                $CurSampleCode = $sample->sample_code;
                $word = explode("-", $CurSampleCode);

                $CurSampleCode = $word[0] ."-".substr($word[1],1);
                //*********************************

                $RequestTemplate .= "<tr>";
                if ($CurSampleCode != $PrevSampleCode) {
                    $RequestTemplate .= "<td style='color:#0f17c4' class='text-left border-left-line border-top-line border-bottom-line padding-left-5' colspan='2'>$sample->samplename</td>";
                    $RequestTemplate .= "<td style='color:#0f17c4' class='text-left border-left-line border-top-line border-right-line border-bottom-line padding-left-5'>$CurSampleCode</td>";
                } else {
                    $RequestTemplate .= "<td class='text-left border-left-line border-top-line border-bottom-line' colspan='2'></td>";
                    $RequestTemplate .= "<td class='text-left border-right-line border-top-line border-left-line border-bottom-line'></td>";
                }
                $analysisfirst = 0;
                //loops every analyses in the sample
                foreach($sample->analyses as $analysis){
                    //get the fee
                    $totalfee += $analysis->fee;

                    if($analysisfirst==0){
                        $analysisfirst++; //increment so that it will just run on the first try
                    }else{
                        //put 2 empty td
                        $RequestTemplate .= "<tr>";
                        $RequestTemplate .= "<td class='text-left border-left-line border-top-line border-bottom-line' colspan='2'></td>";
                        $RequestTemplate .= "<td class='text-left border-right-line border-top-line border-left-line border-bottom-line'></td>";
                    }
                    $RequestTemplate .= "<td style='color:#0f17c4' class='text-left border-bottom-line border-top-line border-right-line padding-left-5' colspan='2'>$analysis->testname</td>";
                    $RequestTemplate .= "<td style='color:#0f17c4;word-wrap: break-word;' class='text-left border-bottom-line border-top-line border-right-line padding-left-5 padding-right-5' colspan='2'>$analysis->method</td>";
                    $RequestTemplate .= "<td style='color:#0f17c4' class='text-center border-bottom-line border-top-line border-right-line'>1</td>";
                    $RequestTemplate .= "<td style='color:#0f17c4' class='text-right border-bottom-line border-top-line border-right-line padding-right-5'>$analysis->fee</td>";
                    $RequestTemplate .= "<td style='color:#0f17c4' class='text-right border-bottom-line border-top-line border-right-line padding-right-5'>$analysis->fee</td>";
                    $RequestTemplate .= "</tr>";
                }
                $PrevSampleCode = $CurSampleCode;
               }
            }

            $discount = $totalfee * ($request->discount /100); //request->total is already discounted so it is an overall total
            $subtotal = $totalfee; //to get the subtotal we need to add the discount to the total

            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td style='color:#0f17c4' class='text-left border-left-line border-top-line border-bottom-line padding-left-5' colspan='2'></td>";
            $RequestTemplate .= "<td style='color:#0f17c4' class='text-left border-left-line border-top-line border-right-line border-bottom-line padding-left-5'></td>";
            $RequestTemplate .= "<td style='color:#0f17c4' class='text-left border-bottom-line border-top-line border-right-line padding-left-5' colspan='2'></td>";
            $RequestTemplate .= "<td style='color:#0f17c4;word-wrap: break-word;' class='text-left border-bottom-line border-top-line border-right-line padding-left-5 padding-right-5' colspan='2'></td>";
            
            $RequestTemplate .= "<td class='text-right border-left-line  border-bottom-line'></td>";
            $RequestTemplate .= "<td class='text-right border-left-line border-bottom-line padding-right-5'>Sub-Total</td>";
            $RequestTemplate .= "<td style='color:#0f17c4;font-weight:bold;font-size:10px' class='text-right border-left-line border-bottom-line border-right-line padding-right-5'>".number_format($subtotal,2)."</td>";
            $RequestTemplate .= "</tr>";
            // Discount
            $RequestTemplate .= "<tr>";
             $RequestTemplate .= "<td style='color:#0f17c4' class='text-left border-left-line border-top-line border-bottom-line padding-left-5' colspan='2'></td>";
            $RequestTemplate .= "<td style='color:#0f17c4' class='text-left border-left-line border-top-line border-right-line border-bottom-line padding-left-5'></td>";
            $RequestTemplate .= "<td style='color:#0f17c4' class='text-left border-bottom-line border-top-line border-right-line padding-left-5' colspan='2'></td>";
            $RequestTemplate .= "<td style='color:#0f17c4;word-wrap: break-word;' class='text-left border-bottom-line border-top-line border-right-line padding-left-5 padding-right-5' colspan='2'></td>";
            
            $RequestTemplate .= "<td class='text-right border-left-line border-bottom-line'></td>";
            $RequestTemplate .= "<td class='text-right border-left-line border-bottom-line padding-right-5'>Discount</td>";
            $RequestTemplate .= "<td style='color:#0f17c4;font-weight:bold;font-size:10px' class='text-right border-left-line border-bottom-line border-right-line padding-right-5'>".number_format($discount,2)."</td>";
            $RequestTemplate .= "</tr>";

            
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-right' colspan='8'></td>";
            $RequestTemplate .= "<th class='text-right padding-right-5'></th>";
            // $Total=$request->total-$request->;
            $RequestTemplate .= "<th style='color:#0f17c4' class='text-right padding-right-5'></th>";
            
            $RequestTemplate .= "</tr>";
            
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='10' class='text-left'>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<th colspan='10' class='text-left border-bottom-line'>2. BRIEF DESCRIPTION OF THE SAMPLE/REMARKS</th>";
            $RequestTemplate .= "</tr>";
            //BRIEF DESCRIPTION
            $CurSampleCode2 = "";
            $PrevSampleCode2 = "";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-left border-left-line border-top-line border-right-line padding-right-5 padding-left-5' colspan='10'>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
            foreach ($request->samples as $sample) {
                if($sample->active == 1){
                    //************************************
                    //temporary
                    //lab personnel wants to only have 4 digit figure in sample code
                    $CurSampleCode2 = $sample->sample_code;
                    $word = explode("-", $CurSampleCode2);

                    $CurSampleCode2 = $word[0] ."-".substr($word[1],1);
                    //*********************************
                  
                    if ($CurSampleCode2 != $PrevSampleCode2) {
                        $RequestTemplate .= "<tr>";
                        $RequestTemplate .= "<td style='color:#0f17c4;' class='text-left border-left-line border-right-line padding-left-5' colspan='10'> ".$CurSampleCode2." : <i>".$sample->customer_description."</i>, ".$sample->description."</td>";
                        $RequestTemplate .= "</tr>";
                    }
                    $PrevSampleCode2 = $CurSampleCode2;
                }
            }
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-left border-left-line border-bottom-line border-right-line padding-right-5 padding-left-5' colspan='10'>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-left' colspan='10'>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
            
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='4'></td>";
            $RequestTemplate .= "<td colspan='3'></td>";
            $strGratis="";
            if($request->discount_id == 8)
            {
                $strGratis = '(Gratis)';
            }
            $RequestTemplate .= "<td colspan='2' class='text-right text-bold border-bottom-line' style='font-size:10px'>TOTAL ". $strGratis . ": </td>";
            $RequestTemplate .= "<td  style='color:#0f17c4;font-size:10px' colspan='3' class='text-right text-bold border-bottom-line'>₱ ".number_format($request->total,2)."</td>";
            $RequestTemplate .= "</tr>";
            
             $RequestTemplate .= "<tr ><td style='height:10px'></td></tr>";

             //We need to get the OR details of this request
             $payments = Paymentitem::find()->where(['request_id'=>$request->request_id])->all();
             // var_dump($payments); exit;
             $OR_NUMBERS = "";
             $OR_DATES = "";
             if($payments){
                foreach ($payments as $payment) {
                    //get the receipt
                    $receipt = Receipt::find($payment->receipt_id);
                    if($receipt){

                        if($OR_NUMBERS!=="")
                        $OR_NUMBERS .=",";

                        if($OR_DATES!=="")
                            $OR_DATES .=",";  
                         //this is just temporary still need to see the receipt structure
                        //no or for now
                         // $OR_NUMBERS .= $receipt->or_number;
                         // $OR_DATES .= $receipt->receiptDate;
                    }
                 }
             }
            //Footer
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='2' class='text-left border-left-line border-top-line padding-left-5'>Official Receipt No.:</td>";
            $RequestTemplate .= "<td  style='color:#0f17c4' class='text-left border-top-line padding-left-5' colspan='4'>".$OR_NUMBERS."</td>";
            $RequestTemplate .= "<td style='border-left: 1px solid black' class='text-right border-top-line padding-left-5' colspan='3'>Amount Received:</td>";
          //  $RequestTemplate .= "<td colspan='2' style='color:blue' class='text-right border-top-line padding-left-5 border-right-line padding-right-5'>".number_format($RequestHeader->TotalAmount,2)."</td>";
            $RequestTemplate .= "<td colspan='2' style='color:#0f17c4' class='text-right border-top-line padding-left-5 border-right-line padding-right-5'></td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='2' class='text-left border-bottom-line border-left-line padding-left-5'>Date:</td>";
            $RequestTemplate .= "<td style='color:#0f17c4;' class='text-left border-bottom-line padding-left-5' colspan='4'>".$OR_NUMBERS."</td>";
            $RequestTemplate .= "<td style='border-left: 1px solid black;' class='text-right border-bottom-line padding-left-5' colspan='3'>Unpaid Balance:</td>";

            $RequestTemplate .= "<td style='color:#0f17c4;' colspan='2' class='text-right border-bottom-line padding-left-5 border-right-line padding-right-5'></td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-left' colspan='10'>&nbsp;</td>";
            $RequestTemplate .= "</tr>";
             //Report Due
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-left border-bottom-line border-left-line border-top-line padding-left-5'>Report Due On:</td>";
            $RequestTemplate .= "<td style='color:#0f17c4' class='text-left border-bottom-line border-top-line padding-left-5' colspan='4'>".date('F d, Y', strtotime($request->report_due))." 4:00 pm</td>";

            $RequestTemplate .= "<td class='text-right border-bottom-line border-top-line padding-left-5' colspan='3'></td>";
            $RequestTemplate .= "<td colspan='2' class='text-right border-bottom-line border-top-line padding-left-5 border-right-line padding-right-5'></td>";
            $RequestTemplate .= "</tr>";
             //Divider
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-left' colspan='10'>&nbsp;</td>";
            $RequestTemplate .= "</tr>";

            $RequestTemplate .= "</table>";
            

            
            $RequestTemplate .= "<table style='width: 100%;border-collapse:collapse;font-size: 11px'><tbody>";
            $RequestTemplate .= "<tr>";

            $RequestTemplate .= "<td class='text-left border-bottom-line padding-right-5' style='width: 33%;'>Discussed with Customer</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .="<tr>";
            $RequestTemplate .= "<td class='text-left border-left-line border-top-line padding-left-5 border-right-line padding-right-5' style='width: 34%;'>Conforme:</td>";
            $RequestTemplate .= "<td class='text-left border-left-line border-top-line padding-left-5 border-right-line padding-right-5' style='width: 33%;'></td>";
            $RequestTemplate .= "<td class='text-left border-left-line border-top-line padding-left-5 border-right-line padding-right-5' style='width: 33%;'></td>";     
            $RequestTemplate .="<tr>";
            
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-center valign-bottom border-left-line border-bottom-line padding-left-5 border-right-line padding-right-5' style='height:35px;color:#0f17c4;width: 34%; '>".strtoupper($request->conforme)."</td>";
            $RequestTemplate .= "<td class='text-center valign-bottom border-left-line border-bottom-line padding-left-5 border-right-line padding-right-5' style='color:#0f17c4;width: 33%;'>".strtoupper($request->receivedBy)."</td>";

            //get the lab manager
            $labmanager =  LabManager::find()->where(['lab_id'=>$request->lab_id])->one();
            $RequestTemplate .= "<td class='text-center valign-bottom border-left-line border-bottom-line padding-left-5 border-right-line padding-right-5' style='color:#0f17c4;width: 33%;'>".strtoupper($Func->getProfileName($labmanager->user_id))."</td>";
            $RequestTemplate .= "</tr>";
            
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-center border-bottom-line border-left-line border-top-line padding-left-5 border-right-line padding-right-5' style='width: 34%;'>Customer/Authorized Representative</td>";
            $RequestTemplate .= "<td class='text-center border-bottom-line border-left-line border-top-line padding-left-5 border-right-line padding-right-5' style='width: 33%;'>Sample/s Received By:</td>";
            $RequestTemplate .= "<td class='text-center border-bottom-line border-left-line border-top-line padding-left-5 border-right-line padding-right-5' style='width: 33%;'>Sample/s Reviewed By:</td>";
            $RequestTemplate .= "</tr>";
            
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td class='text-left border-left-line border-bottom-line border-top-line padding-left-5 padding-right-5' style='width: 34%;'>Report No.:</td>";
            $RequestTemplate .= "<td class='text-left border-bottom-line border-top-line padding-left-5 padding-right-5' style='width: 33%;'></td>";
            $RequestTemplate .= "<td class='text-left border-bottom-line border-top-line padding-left-5 border-right-line padding-right-5' style='width: 33%;'></td>";
            $RequestTemplate .= "</tr></tbody>";
            
            $RequestTemplate .= "<tfoot>";
            $RequestTemplate .= "<tr>";
            $RequestTemplate .= "<td colspan='10' style='text-align: right;font-size: 7px'>$Form</td>";
            $RequestTemplate .= "</tr>";
            $RequestTemplate .= "</tfoot>";
            
            
            
            $RequestTemplate .="</table>";

            
        } else {
            $RequestTemplate = "<table border='0' width=100%>";
            $RequestTemplate .= "</table>";
        }
        return $RequestTemplate;
        
    }
    
    
    
    
    private function sentenceCase($string) { 
    $sentences = preg_split('/([., ?!]+)/', $string, -1,PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE); 
    $newString = ''; 
    foreach ($sentences as $key => $sentence) { 
        $newString .= ($key & 1) == 0? 
            ucfirst(strtolower(trim($sentence))) : 
            $sentence.' '; 
    } 
    return trim($newString); 
    }
    
    



}


