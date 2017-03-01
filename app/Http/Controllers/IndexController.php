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
            'pagenum' => ['.last>a', 'href']
        );

        $data1 = \QL\QueryList::Query($page, $rulespage)->data;
        $pageurl = $data1[0]['pagenum'];

        $maxPage = str_replace('?cate_no=25&page=', '', $pageurl);

        $array = array();
        $array['maxpage'] = $maxPage;
        return view('student.index', $array);
    }

    public function getData(Request $request)
    {

        $p = $request->input('p');
        $price0 = $request->input('price0');
        $price1 = $request->input('price1');

        if(!is_numeric($price0)){
            return json_encode(array('msg'=>'价格最小位数必须为数字','sts'=>0));
        }

        if(!is_numeric($price1)){
            return json_encode(array('msg'=>'价格最大为数必须为数字','sts'=>0));
        }

        $page = 'http://www.3tempo.co.kr/product/list.html?cate_no=25&page=' . $p;
        //采集规则
        $rules = array(
            'product_no' => ['.name>a', 'text'],
            'price' => ['.xans-record->span:first', 'text'],
            'title' => ['.xans-record->span:last', 'text'],
            'main_pic' => ['.thumb', 'src'],
            'product_url' => ['.box>a', 'href']
        );

        //列表选择器
        if ($p == 1) {
            //第一页就把best四个也显示出来。。
            $rang = '.column4>li';
        } else {
            $rang = '.column4:last>li';
        }
        //采集
        $data = \QL\QueryList::Query($page, $rules, $rang)->data;

        //
        $dataarr = array();

        if (!empty($data)) {
            foreach ($data as &$rw) {
                $rw['product_url'] = 'http://www.3tempo.co.kr/' . $rw['product_url'];
                $rw['_countprice'] = strlen($rw['price']);
                $_price = str_replace(',','',$rw['price']);
                $rw['_price'] = str_replace('원','',$_price);

                if ($price0 != '' || $price1 != '') {

                    if ($price0 != '' && $price1 == '') {
                        if (strlen($rw['_price']) >= $price0) {
                            array_push($dataarr, $rw);
                        }
                    }

                    if ($price0 == '' && $price1 != '') {
                        if (strlen($rw['_price']) <= $price1) {
                            array_push($dataarr, $rw);
                        }
                    }

                    if ($price0 != '' && $price1 != '') {
                        if ($price0 <= strlen($rw['_price']) && strlen($rw['_price']) <= $price1){
                            array_push($dataarr, $rw);
                        }
                    }
                }else{
                    array_push($dataarr, $rw);
                }

            }
        }


        $array = array();
        $array['sts'] = 1;
        $array['list'] = $dataarr;
        echo json_encode($array);
    }
}

?>
