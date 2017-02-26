<?php
namespace App\Http\Controllers;
use App\Models\Student\StudentForm;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Request;

/**
 *
 */
class IndexController extends Controller
{
    public function add()
    {
        $sForm = new StudentForm();
        $tbool = $sForm->add();
        echo $tbool;
    }

    public function index()
    {
        //待采集的目标页面，PHPHub教程区
        $page = 'http://www.3tempo.co.kr/product/list.html?cate_no=25';
        //采集规则
        $rulespage = array(
            'pagenum' => ['.last>a','href']
        );

        $data1 = \QL\QueryList::Query($page,$rulespage)->data;
        $pageurl = $data1[0]['pagenum'];

        $maxPage = str_replace('?cate_no=25&page=','',$pageurl);

        $array = array();
        $array['maxpage'] = $maxPage;
        return view('student.index', $array);
    }

    public function getData(Request $request){

        $p = $request->input('p');

        $page = 'http://www.3tempo.co.kr/product/list.html?cate_no=25&page='.$p;
        //采集规则
        $rules = array(
            'product_no' => ['.name>a','text'],
            'price' => ['.xans-record->span:first','text'],
            'title' => ['.xans-record->span:last','text'],
            'main_pic' => ['.thumb','src'],
            'product_url' => ['.box>a','href']
        );

        //列表选择器
        if($p == 1){
            //第一页就把best四个也显示出来。。
            $rang = '.column4>li';
        }else {
            $rang = '.column4:last>li';
        }
        //采集
        $data = \QL\QueryList::Query($page,$rules,$rang)->data;

        if(!empty($data)){
            foreach ($data as &$rw){
                $rw['product_url'] = 'http://www.3tempo.co.kr/'.$rw['product_url'];
            }
        }


        $array = array();
        $array['list'] = $data;
        echo json_encode($array);
    }
}

?>
