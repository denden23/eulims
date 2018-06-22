<?php

namespace frontend\modules\lab\controllers;

use Yii;
use common\models\lab\Sample;
use common\models\lab\SampleSearch;
use common\models\lab\Sampletype;
use common\models\lab\Testcategory;
use common\models\lab\Request;
use common\models\lab\Lab;
use common\models\lab\Samplecode;
use common\models\lab\SampleName;
use common\models\lab\Analysis;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\web\Response;
use yii\db\ActiveQuery;
use common\components\Functions;

/**
 * SampleController implements the CRUD actions for Sample model.
 */
class SampleController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'generatesamplecode'=>['GET','POST']
                ],
            ],
        ];
    }

    /**
     * Lists all Sample models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SampleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize=10;

        /*$dataProvider = new ActiveDataProvider([
            //'query' => $searchModel->search(Yii::$app->request->queryParams),
            'query' =>$searchModel,
            'pagination' => [
                'pagesize' => 10,
            ],
        ]);*/

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'sampletypes' => $this->listSampletype(),
        ]);
    }

    /**
     * Displays a single Sample model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $searchModel = new SampleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //$dataProvider->sort->sortParam = false;

        return $this->render('view', [
            'model' => $this->findModel($id),
            //'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

        ]);
    }

    /**
     * Creates a new Sample model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Sample();

        $session = Yii::$app->session;
        //$req = Yii::$app->request;

        if(Yii::$app->request->get('request_id'))
        {
            $requestId = (int) Yii::$app->request->get('request_id');
        }
        $request = $this->findRequest($requestId);
        $labId = $request->lab_id;

        $testcategory = $this->listTestcategory($labId);
        //$sampletype = $this->listSampletype();
        /*$testcategory = ArrayHelper::map(Testcategory::find()
            ->where(['lab_id' => $labId])
            ->all(), 'testcategory_id', 'category_name');*/
        $sampletype = [];

        //if ($model->load(Yii::$app->request->post()) && $model->save()) {
        if ($model->load(Yii::$app->request->post())) {
            if(isset($_POST['Sample']['sampling_date'])){
                $model->sampling_date = date('Y-m-d', strtotime($_POST['Sample']['sampling_date']));
            } else {
                $model->sampling_date = date('Y-m-d');
            }

            $model->rstl_id = $GLOBALS['rstl_id'];
            //$model->sample_code = 0;
            $model->request_id = $request->request_id;
            $model->sample_month = date_format(date_create($request->request_datetime),'m');
            $model->sample_year = date_format(date_create($request->request_datetime),'Y');
            //$model->sampling_date = date('Y-m-d');

            if(isset($_POST['qnty'])){
                $quantity = (int) $_POST['qnty'];
            } else {
                $quantity = 1;
            }

            if(isset($_POST['sample_template']))
            {
                $this->saveSampleTemplate($_POST['Sample']['samplename'],$_POST['Sample']['description']);
            }

            if($quantity>1)
            {
                for ($i=1;$i<=$quantity;$i++)
                {
                    $sample = new Sample();

                    if(isset($_POST['Sample']['sampling_date'])){
                        $sample->sampling_date = date('Y-m-d', strtotime($_POST['Sample']['sampling_date']));
                    } else {
                        $sample->sampling_date = date('Y-m-d');
                    }
                    $sample->rstl_id = $GLOBALS['rstl_id'];
                    //$sample->sample_code = 0;
                    $sample->testcategory_id = (int) $_POST['Sample']['testcategory_id'];
                    $sample->sample_type_id = (int) $_POST['Sample']['sample_type_id'];
                    $sample->samplename = $_POST['Sample']['samplename'];
                    $sample->description = $_POST['Sample']['description'];
                    $sample->request_id = $request->request_id;
                    $sample->sample_month = date('m', strtotime($request->request_datetime));
                    $sample->sample_year = date('Y', strtotime($request->request_datetime));
                    $sample->save(false);
                }
                //return $this->redirect('index');
                $session->set('savemessage',"executed");
                return $this->redirect(['/lab/request/view', 'id' => $requestId]);
            } else {
                if($model->save(false)){
                    //return $this->redirect(['view', 'id' => $model->sample_id]);
                    //echo Json::encode('Successfully saved.');
                    $session->set('savemessage',"executed");
                    return $this->redirect(['/lab/request/view', 'id' => $requestId]);
                }
            }

        } elseif (Yii::$app->request->isAjax) {
                return $this->renderAjax('_form', [
                    'model' => $model,
                    'testcategory' => $testcategory,
                    'sampletype' => $sampletype,
                    'labId' => $labId,
                    'sampletemplate' => $this->listSampletemplate(),
                ]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'testcategory' => $testcategory,
                'sampletype' => $sampletype,
                'labId' => $labId,
                'sampletemplate' => $this->listSampletemplate(),
            ]);
        }
    }

    /**
     * Updates an existing Sample model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        //\Yii::$app->response->format = Response:: FORMAT_JSON;
        $model = $this->findModel($id);

        /*if(isset($_GET['request_id']))
        {
            $requestId = (int) $_GET['request_id'];
        }*/

        $session = Yii::$app->session;

        $request = $this->findRequest($model->request_id);
        $labId = $request->lab_id;

        $testcategory = $this->listTestcategory($labId);
        //$sampletype = $this->listSampletype();

        $sampletype = ArrayHelper::map(Sampletype::find()
                ->where(['testcategory_id' => $model->testcategory_id])
                ->all(), 'sample_type_id', 'sample_type');

        /*if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->sample_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }*/

        if ($model->load(Yii::$app->request->post())) {
            if(isset($_POST['Sample']['sampling_date'])){
                $model->sampling_date = date('Y-m-d', strtotime($_POST['Sample']['sampling_date']));
            } else {
                $model->sampling_date = date('Y-m-d');
            }

            if($model->save(false)){
                $session->set('updatemessage',"executed");
                return $this->redirect(['/lab/request/view', 'id' => $model->request_id]);

            }
        } elseif (Yii::$app->request->isAjax) {
                return $this->renderAjax('_form', [
                    'model' => $model,
                    'testcategory' => $testcategory,
                    'sampletype' => $sampletype,
                    'labId' => $labId,
                    'sampletemplate' => $this->listSampletemplate(),
                ]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'testcategory' => $testcategory,
                'sampletype' => $sampletype,
                'labId' => $labId,
                'sampletemplate' => $this->listSampletemplate(),
            ]);
        }
    }

    /**
     * Deletes an existing Sample model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        //$this->findModel($id)->delete();
        //return;

        $model = $this->findModel($id);
        //$sampleId = (int) $id;
        $session = Yii::$app->session;
        $analyses = Analysis::find()->where(['sample_id' => $id])->all();

        if(count($analyses) > 0){
            return $model->samplename." has analysis. Remove first the analysis then delete this sample.";
        } else {
            //$delete = $this->findModel($id);

            if($model->delete()) {
                //$session->set('deletemessage',"executed");
                //return;
                $session->set('deletemessage',"executed");
                return $this->redirect(['/lab/request/view', 'id' => $model->request_id]);
            } else {
                return $model->error();
            }
        }
    }

    /**
     * Cancel an existing Sample model.
     * @param integer $id
     * @return mixed
     */
    public function actionCancel($id)
    {
        //$this->findModel($id)->delete();
        //return;
        $model = $this->findModel($id);
        $session = Yii::$app->session;
        $sampleId = (int) $id;
        $analyses = Analysis::find()->where('sample_id =:sampleId', [':sampleId'=>$sampleId])->all();

        if(count($analyses) > 0)
        {
            foreach ($analyses as $analysis) {
                //$analysis->delete(); //to delete
                $analyses->cancelled = 1;
                $analyses->update(false); // skipping validation as no user input is involved
            }

            $model->active = 0;
            if ($model->update() !== false) {
                $session->set('cancelmessage',"executed");
                return $this->redirect(['/lab/request/view', 'id' => $model->request_id]);
            } else {
                $model->error();
                return false;
            }
        } else {

            $model->active = 0;
            //$model->update();

            if ($model->update() !== false) {
                $session->set('cancelmessage',"executed");
                return $this->redirect(['/lab/request/view', 'id' => $model->request_id]);
            } else {
                $model->error();
                return false;
            }
        }
    }

    /**
     * Finds the Sample model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Sample the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Sample::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function listSampletype()
    {
        $sampletype = ArrayHelper::map(Sampletype::find()->all(), 'sample_type_id', 
            function($sampletype, $defaultValue) {
                return $sampletype->sample_type;
        });

        return $sampletype;
    }

  

    protected function listTestcategory($labId)
    {
        $testcategory = ArrayHelper::map(Testcategory::find()->andWhere(['lab_id'=>$labId])->all(), 'testcategory_id', 
           function($testcategory, $defaultValue) {
               return $testcategory->category_name;
        });

        /*$testcategory = ArrayHelper::map(Testcategory::find()
            ->where(['lab_id' => $labId])
            ->all(), 'testcategory_id', 'category_name');*/

        return $testcategory;
    }

    public function actionListsampletype() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id = end($_POST['depdrop_parents']);
            $list = Sampletype::find()->andWhere(['testcategory_id'=>$id])->asArray()->all();
            $selected  = null;
            if ($id != null && count($list) > 0) {
                $selected = '';
                foreach ($list as $i => $sampletype) {
                    $out[] = ['id' => $sampletype['sample_type_id'], 'name' => $sampletype['sample_type']];
                    if ($i == 0) {
                        $selected = $sampletype['sample_type_id'];
                    }
                }
                // Shows how you can preselect a value
                echo Json::encode(['output' => $out, 'selected'=>$selected]);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected'=>'']);
    }

    /*protected function find()
    {
        $sampletype = ArrayHelper::map(Sampletype::find()->all(), 'sample_type_id', 
            function($sampletype, $defaultValue) {
                return $sampletype->sample_type;
        });

        return $sampletype;
    }*/

    protected function findRequest($requestId)
    {
        if (($model = Request::findOne($requestId)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGeneratesamplecode()
    {
        $requestId = (int) Yii::$app->request->get('request_id');
        $request = $this->findRequest($requestId);
        $lab = Lab::findOne($request->lab_id);
        $year = date('Y', strtotime($request->request_datetime));
        $connection= Yii::$app->labdb;
        
        foreach ($request->samples as $samp){
            $transaction = $connection->beginTransaction();
            $return="false";
            try {

                $function = new Functions();
                $proc = 'spGetNextGenerateSampleCode(:rstlId,:labId,:requestId)';
                $params = [':rstlId'=>$GLOBALS['rstl_id'],':labId'=>$lab->lab_id,':requestId'=>$requestId];
                $row = $function->ExecuteStoredProcedureOne($proc, $params, $connection);
                $samplecodeGenerated = $row['GeneratedSampleCode'];
                $samplecodeIncrement = $row['SampleIncrement'];

                $sampleId = $samp->sample_id;
                $sample = $this->findModel($sampleId);
                
                //insert to tbl_samplecode
                $samplecode = new Samplecode();
                $samplecode->rstl_id = $GLOBALS['rstl_id'];
                $samplecode->reference_num = $request->request_ref_num;
                $samplecode->sample_id = $sampleId;
                $samplecode->lab_id = $lab->lab_id;
                $samplecode->number = $samplecodeIncrement;
                $samplecode->year = $year;
               
                if($samplecode->save())
                {
                    //update samplecode to tbl_sample
                    $sample->sample_code = $samplecodeGenerated;
                    $sample->save();
                    $transaction->commit();
                    $return=true;
                } else {
                    //error
                    $transaction->rollBack();
                    $samplecode->getErrors();
                    $return=false;
                }
                
                //$transaction->commit();

            } catch (\Exception $e) {
               $transaction->rollBack();
               $return=false;
            } catch (\Throwable $e) {
               $transaction->rollBack();
               $return=false;
            }
            
        }
        echo $return;
    }

    protected function listSampletemplate()
    {
        $sampleTemplate = ArrayHelper::map(SampleName::find()->all(), 'sample_name_id', 
            function($sampleTemplate, $defaultValue) {
                return $sampleTemplate->sample_name;
        });

        return $sampleTemplate;
    }

    public function actionGetlisttemplate() {
        if(isset($_GET['template_id'])){
            $id = (int) $_GET['template_id'];
            $modelSampletemplate =  SampleName::findOne(['sample_name_id'=>$id]);
            if(count($modelSampletemplate)>0){
                $sampleName = $modelSampletemplate->sample_name;
                $sampleDescription = $modelSampletemplate->description;
            } else {
                $sampleName = "";
                $sampleDescription = "";
            }
        } else {
            $sampleName = "Error getting sample name";
            $sampleDescription = "Error getting description";
        }
        return Json::encode([
            'name'=>$sampleName,
            'description'=>$sampleDescription,
        ]);
    }

    protected function saveSampleTemplate($sampleName,$description)
    {
        $modelSampletemplate = new SampleName();

        $modelSampletemplate->sample_name = $sampleName;
        $modelSampletemplate->description = $description;
        $modelSampletemplate->save();

        return $modelSampletemplate;
    }
}