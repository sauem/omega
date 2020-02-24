<?php


namespace backend\controllers;


use Box\Spout\Reader\Common\Creator\ReaderFactory;
use common\helper\HelperFunction;
use common\models\DataInput;
use common\models\DataInputSearch;
use common\models\DataName;
use Yii;
use yii\base\BaseObject;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\queue\JobInterface;
use yii\queue\Queue;
use yii\web\Response;
use yii2tech\spreadsheet\Spreadsheet;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use KHerGe\Excel\Workbook;
use Box\Spout\Common\Type;
use backend\jon\ImportJob;
class DataController extends BaseController
{
    function requiredAuth()
    {
        return parent::requiredAuth(); // TODO: Change the autogenerated stub
    }
    function unrequiredAuth()
    {
        return [
          'index','import'
        ];
    }

    function actionIndex($id = ""){
        $model = new DataName();

        if(\Yii::$app->request->get("id")){
            $model = DataName::findOne($id);
            Self::check($model);
        }
        if(\Yii::$app->request->isPost && $model->load(\Yii::$app->request->post())){
            if($model->save()){
                return $this->refresh();
            }
        }

        $dataProvider = new ActiveDataProvider([
           'query' =>  DataName::find(),
            'pagination' => [
                'pageSize' => 20
            ]
        ]);
        return $this->render('_index',[
            'model' => $model,
            'dataProvider' => $dataProvider
        ]);
    }
    function actionView($parent){
        $model = DataName::findOne($parent);
        Self::check($model);
        $search  = new DataInputSearch();
        $query = Yii::$app->request->queryParams;
        $dataProvider = $search->search($query , $parent);

        return $this->render('_view',[
            'dataProvider' => $dataProvider,
            'searchModel' => $search
        ]);
    }
    function actionDetail($child){
        $model = DataInput::findOne($child);
        Self::check($model);
        return $this->render('_detail',[
           'model' => $model
        ]);
    }
    function actionDelete($id){
        $model = DataName::findOne($id);
        Self::check($model);
        if($model->delete()){
            Self::Success();
            return $this->redirect('/data/index');
        }
        Self::Error($model);
    }
    function actionImport($parent){
        $parent  = DataName::findOne($parent);
        Self::check($parent);

        return $this->render(static::getViewName('_import'),[
            'parent' => $parent->getAttribute('id')
        ]);
    }

    function actionAjaxImport(){
        \Yii::$app->response->format  = Response::FORMAT_JSON;
        if(\Yii::$app->request->isAjax){
            $data =  Yii::$app->request->post("input");
            $step  = Yii::$app->request->post('step');
            $end = Yii::$app->request->post('end');

            $error = [];
            if(empty($data)){
                return [
                    'success' => 0,
                    'msg' => 'Dữ liệu rỗng!'
                ];
            }
            try{

                foreach ($data as $k => $item){
                    if(!empty($item['event_value'])){
                        $uuid = json_decode($item['event_value'],TRUE);
                        $data[$k]['uuid'] = isset($uuid['UUID']) ? $uuid['UUID'] : '';
                    }
                    $data[$k]['attr_touch_time'] = strtotime($item['attr_touch_time']);
                    $data[$k]['install_time'] = strtotime($item['install_time']);
                    $data[$k]['event_time'] = strtotime($item['event_time']);
                }

                Yii::$app->db->createCommand()->batchInsert(
                    DataInput::tableName(),
                    [
                        'name_ID',
                        'attr',
                        'attr_touch_time',
                        'install_time',
                        'event_time',
                        'event_name',
                        'event_value',
                        'event_revenue',
                        'event_revenue_currency',
                        'event_revenue_vnd',
                        'partner',
                        'media_source',
                        'campaign',
                        'campaign_id',
                        'site_id',
                        'sub_site_id',
                        'sub_param_1',
                        'sub_param_2',
                        'sub_param_3',
                        'sub_param_4',
                        'sub_param_5',
                        'ip',
                        'appsflyer_id',
                        'adv_id',
                        'ifa',
                        'android_id',
                        'user_id',
                        'platform',
                        'device_type',
                        'app_name',
                        'created_at',
                        'updated_at',
                        'uuid']
                    ,
                    $data
                )->execute();

            }catch (\Exception $e){
                $error = $e->getMessage();
            }
            return [
                'success' => 1,
                'next' => $end,
                'end' => $end + $step,
                'error' => $error
            ];

        }
    }


    function actionExport(){
        $query =  DataInput::find()->where(['name_ID' => 3])->asArray()->all();


        Yii::$app->response->format  = Response::FORMAT_JSON;
       if(Yii::$app->request->isAjax){

          $id =  Yii::$app->queue->push(new ExportJob());
           Yii::$app->queue->isWaiting($id);
           Yii::$app->queue->isReserved($id);
           Yii::$app->queue->isDone($id);
           return [
             'success' => 1,
             'msg' => 'HELLO'
           ];
           $data = Yii::$app->request->post();
           $model = DataName::findOne($data['parent']);
           Self::check($model);
           $query =  DataInput::find()->where(['name_ID' => 3])->asArray()->all();

           try{
               $export = new Spreadsheet([
                   'title' => 'Raw data',
                   'dataProvider' => new ArrayDataProvider([
                       'allModels' => $query
                   ])
               ]);
               $export->batchSize  = 20;
               $export->render();
               $export->save(Yii::getAlias("@backend/web/export/")."test.xlsx");
               return [
                 'success' => 1,
                 'url' => Url::to('/export/test.xlsx')
               ];
           }catch (\Exception $e){
               return [
                 'success' => 0,
                 'msg' => $e->getMessage()
               ];
           }
       }
        return [
            'success' => 0,
            'msg' => 'Not avalibled'
        ];
    }

    static function createWoorkSheetByMediaSource($source_name = ""){

    }
    static function createWorkSheetMediaTeam(Spreadsheet $export , $name_id){
       return static::createWorkSheetBaseData($export, $name_id );
    }
    static function createWorkSheetBaseData(Spreadsheet $export , $name_id){
        $export->configure([
            'title' => 'Raw data',
            'dataProvider' => new ActiveDataProvider([
                'query' => DataInput::find()->where(['name_ID' => $name_id])
            ])
        ])->render();
        return $export;
    }
    static function createWorkSheetEventName(Spreadsheet $export , $parent = 0, $event_name = []){
        if(isset($event_name) && !empty($event_name)){
            foreach ($event_name as $name){
                $export->configure([
                   'title' => $name . "_uuid_data",
                   'dataProvider' => new ActiveDataProvider([
                       'query' => DataInput::find()
                           ->where(['event_name' => 'addsource_success','name_ID' => 3])
                           ->groupBy('uuid')
                   ])
                ]);
                $export->render();
            }
        }
        return $export;
    }
    static function createWorkSheetDistinct(){

    }
    static function createWorkSheetTotal(){

    }
    static function createWorkSheetCountAttribute(){

    }

    function actionTest(){
     //  Yii::$app->response->format = Response::FORMAT_JSON;
        $filename  = Yii::getAlias("@backend/web/export/2000.csv");

//         Yii::$app->queue->push(new ImportJob([
//             'file' => $filename
//         ]));
//
//        Yii::$app->queue->on(Queue::EVENT_AFTER_ERROR, function (ExecEvent $event) {
//            if ($event->job instanceof SomeJob) {
//                $event->retry = ($event->attempt < 5) && ($event->error instanceof TemporaryException);
//                HelperFunction::error_log($event->eror);
//            }
//        });

        $reader = ReaderEntityFactory::createReaderFromFile($filename);
        $reader->setFieldDelimiter('|');
        $reader->setFieldEnclosure('@');
        $reader->open($filename);
        echo "<pre>";
        foreach ($reader->getSheetIterator() as  $sheet) {
            foreach ($sheet->getRowIterator() as $cell => $row){
                if($cell == 2){
                    $cell = $row->getCells();
                    var_dump($cell[0]);
                }

            }
            break;
        }

        $reader->close();
        die;

    }
}
