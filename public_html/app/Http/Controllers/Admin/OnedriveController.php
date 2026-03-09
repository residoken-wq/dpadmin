<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Krizalys\Onedrive\NameConflictBehavior;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\GenericProvider;
use Mpdf\Http\Exception\ClientException;

use App;
use Image;
use PDF;
use App\Model\Forms as DTForms;
use App\Model\Supplier as DTSupplier;
use App\Model\Customer as DTCustomer;
use App\Model\OrderCustomer as DTOrderCustomer;
use App\Model\OrderSupplier as DTOrderSupplier;
use App\Model\Log as DTLog;
use App\Model\Phieuchi as DTPhieuchi;
use App\Model\Phieuthu as DTPhieuthu;

//use Krizalys\Onedrive\Client;
use GuzzleHttp\Client as GuzzleHttpClient;
use Krizalys\Onedrive\Client;
use Microsoft\Graph\Graph;
use App\TokenStore\TokenCache;
use Artisan;
use RuntimeException;
use Cache;

class OnedriveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $View = [];
    // protected  $config=[
    //             'ONEDRIVE_CLIENT_ID' =>env('ONEDRIVE_CLIENT_ID',"67218437-d7fa-46c0-b81b-e6378aacc964"),
    //             'ONEDRIVE_CLIENT_SECRET' =>"bojqEQTXN1-ctuXA0229+]|",
    //             'ONEDRIVE_CALLBACK_URI' => "https://dtdp.in",
    //         ];
    /* protected  $config=[
                 'ONEDRIVE_CLIENT_ID' =>env('DB_CONNECTION',"67218437-d7fa-46c0-b81b-e6378aacc964"),
                 'ONEDRIVE_CLIENT_SECRET' =>env('DB_CONNECTION',"bojqEQTXN1-ctuXA0229+]|"),
                 'ONEDRIVE_CALLBACK_URI' => env("DB_CONNECTION","https://dtdp.in"),
             ];*/
    protected $config;
    protected $scope;
    protected $OneDrive;

    public function __construct()
    {

//        if (App::environment('local')) {
//            $this->config = [
////                'ONEDRIVE_CLIENT_ID' => "7baee393-8159-4751-877f-b84d66462917",
////                'ONEDRIVE_CLIENT_SECRET' => "?:tEDn7zz@[P2eHSbo5FZUxdpvKvgOL7",
//                'ONEDRIVE_CLIENT_ID' => "67218437-d7fa-46c0-b81b-e6378aacc964",//"67218437-d7fa-46c0-b81b-e6378aacc964",
//                'ONEDRIVE_CLIENT_SECRET' => "8v973JRX_HM+fQLDX[YnU:=R+ld*iOhf",//"bojqEQTXN1-ctuXA0229+]|",
//                'ONEDRIVE_CALLBACK_URI' => "https://dtdp.in",
//            ];
//
//            Artisan::call("view:clear");
//            Artisan::call("cache:clear");
//            Cache::flush();
//
//        } else {
//            $this->config = [
////                'ONEDRIVE_CLIENT_ID' => "8af3923f-2e65-4b7c-bc0b-8b52b19de073",
////                'ONEDRIVE_CLIENT_SECRET' => "ZdO8Q~~N6drWEx6FqR_MRRwD2QhwIXvsvN2Wwbs-",
////                'ONEDRIVE_CALLBACK_URI' => "https://dtdp.local",
//                'ONEDRIVE_CLIENT_ID' => "67218437-d7fa-46c0-b81b-e6378aacc964",//"67218437-d7fa-46c0-b81b-e6378aacc964",
//                'ONEDRIVE_CLIENT_SECRET' => "8v973JRX_HM+fQLDX[YnU:=R+ld*iOhf",//"bojqEQTXN1-ctuXA0229+]|",
//                'ONEDRIVE_CALLBACK_URI' => "https://dtdp.in",
//            ];
//        }


        $this->config = [
            'ONEDRIVE_CLIENT_ID' => "67218437-d7fa-46c0-b81b-e6378aacc964",//"67218437-d7fa-46c0-b81b-e6378aacc964",
            'ONEDRIVE_CLIENT_SECRET' => "8v973JRX_HM+fQLDX[YnU:=R+ld*iOhf",//"bojqEQTXN1-ctuXA0229+]|",
            'ONEDRIVE_CALLBACK_URI' => "https://dtdp.in",
//
//            'ONEDRIVE_CLIENT_ID' => "8af3923f-2e65-4b7c-bc0b-8b52b19de073",
//            'ONEDRIVE_CLIENT_SECRET' => "ZdO8Q~~N6drWEx6FqR_MRRwD2QhwIXvsvN2Wwbs-",
//            'ONEDRIVE_CALLBACK_URI' => "https://dtdp.local",
        ];

        $this->scope = [
            'files.read',
            'files.read.all',
            'files.readwrite',
            'files.readwrite.all',
            'offline_access',
        ];
    }

    public function loginUrl(Request $request)
    {

//        $OneDrive = new Client(
//            config('azure.appId'),
//            new Graph(),
//            new GuzzleHttpClient()
//        );
//
//        // Gets a log in URL with sufficient privileges from the OneDrive API.
//        $authUrl = $OneDrive->getLogInUrl($this->scope, $this->config['ONEDRIVE_CALLBACK_URI'] . "/admin/index/onedrive");
//
        $oauthClient = new GenericProvider([
            'clientId' => config('azure.appId'),
            'clientSecret' => config('azure.appSecret'),
            'redirectUri' => config('azure.redirectUri'),
            'urlAuthorize' => config('azure.authority') . config('azure.authorizeEndpoint'),
            'urlAccessToken' => config('azure.authority') . config('azure.tokenEndpoint'),
            'urlResourceOwnerDetails' => '',
            'scopes' => config('azure.scopes')
        ]);
        $authUrl = $oauthClient->getAuthorizationUrl();
//        $_SESSION['oauthState'] = $oauthClient->getState();
//        $_SESSION['userAuthHash'] = $request->get('auth_hash');
        Session::put('oauthState', $oauthClient->getState());
//        Session::put('userAuthHash', $request->get('auth_hash'));
        Session::save();
        return redirect($authUrl);

//        return Redirect::to($authUrl);
    }

    public function pathwork(Request $request)
    {
        $oauthClient = new GenericProvider([
            'clientId' => config('azure.appId'),
            'clientSecret' => config('azure.appSecret'),
            'redirectUri' => config('azure.redirectUri'),
            'urlAuthorize' => config('azure.authority') . config('azure.authorizeEndpoint'),
            'urlAccessToken' => config('azure.authority') . config('azure.tokenEndpoint'),
            'urlResourceOwnerDetails' => '',
            'scopes' => config('azure.scopes')
        ]);
        $authUrl = $oauthClient->getAuthorizationUrl();
//        $_SESSION['oauthState'] = $oauthClient->getState();
//        $_SESSION['userAuthHash'] = $request->get('auth_hash');
        Session::put('oauthState', $oauthClient->getState());
//        Session::put('userAuthHash', $request->get('auth_hash'));
        Session::save();
//        dd($authUrl);
//        return redirect($authUrl);
//
//        $OneDrive = new Client(
//            config('azure.appId'),
//            new Graph(),
//            new GuzzleHttpClient()
//        );
//        // Gets a log in URL with sufficient privileges from the OneDrive API.
//        $url = $OneDrive->getLogInUrl($this->scope, $this->config['ONEDRIVE_CALLBACK_URI'] . "/admin/index/onedrive");
//
////        Auth::user()->update(['onedrive_token' => $OneDrive->getState()->token->data->access_token]);
////        Session::put('onedrivec_cronjob', $OneDrive->getState());
//        Session::put('onedrive', $OneDrive->getState());
//        Session::save();
        return view("admin.onedrive.first", ['url' => $authUrl]);
    }

    public function onedrive(Request $request)
    {

        $expectedState = Session::get('oauthState');
//        $userAuthHash = Session::get('userAuthHash');
        Session::forget('oauthState');
        Session::forget('userAuthHash');
        $providedState = $request->query('state');

        if (!isset($expectedState)) {
            // If there is no expected state in the session,
            // do nothing and redirect to the home page.

            return redirect()->route('onedrive.pathwork')
                ->with('error', 'Invalid auth state')
                ->withErrors('errorDetail', 'The provided auth state did not match the expected value');
        }

//        if (!isset($userAuthHash)) {
//            // If there is no expected state in the session,
//            // do nothing and redirect to the home page.
//            throw new RuntimeException('fail to find auth_hash into the current session.');
//        }

        if (!isset($providedState) || $expectedState != $providedState) {
            return redirect()->route('onedrive.pathwork')
                ->with('error', 'Invalid auth state')
                ->withErrors('errorDetail', 'The provided auth state did not match the expected value');
        }
        $authCode = $request->query('code');
        if (isset($authCode)) {
            // Initialize the OAuth client
            $oauthClient = new GenericProvider([
                'clientId' => config('azure.appId'),
                'clientSecret' => config('azure.appSecret'),
                'redirectUri' => config('azure.redirectUri'),
                'urlAuthorize' => config('azure.authority') . config('azure.authorizeEndpoint'),
                'urlAccessToken' => config('azure.authority') . config('azure.tokenEndpoint'),
                'urlResourceOwnerDetails' => '',
                'scopes' => config('azure.scopes')
            ]);

            try {
                // Make the token request
                $accessToken = $oauthClient->getAccessToken('authorization_code', [
                    'code' => $authCode
                ]);

                $graph = new Graph();
                $graph->setAccessToken($accessToken->getToken());

                $user = Auth::user();

                $tokenCache = new TokenCache();
                $tokenCache->storeTokens($accessToken, $user);

                return redirect("/admin/index/runonedrive?success");
            } catch (IdentityProviderException $e) {
//                dd(json_encode($e->getResponseBody()));
                return redirect("/admin/index/pathwork?e=" . json_encode($e->getResponseBody()));
//                return redirect()->route('onedrive.pathwork')
//                    ->with('error', 'Error requesting access token')
//                    ->with('errorDetail', json_encode($e->getResponseBody()));
            }
        }

        return redirect()->route('onedrive.pathwork')
            ->with('error', 'Error requesting access token')
            ->with('errorDetail', 'There\'s no authCode in session.');
//        throw new RuntimeException("There's no authCode in session.");

//        try {
//            if (isset($_GET['error_description'])) {
//                echo "<h1> Đăng nhập không thành công. </h1>";
//                var_export(htmlentities($_GET['error_description']));
//                dd('t');
//            }
//            //dd(Session::get('onedrivec'));
//
//            $onedrive = new Client(
//                config('azure.appId'),
//                new Graph(),
//                new GuzzleHttpClient(),
//                [
//                    // Restore the previous state while instantiating this client to proceed
//                    // in obtaining an access token.
//                    'client_id' => config('azure.appId'),
////                    'state' => Auth::user()->onedrive_token,
//                    'state' => Session::get('onedrive')
//                ]
//            );
//
//            // dd($_GET['code']);
//            // Obtain the token using the code received by the OneDrive API.
//            $onedrive->obtainAccessToken(config('azure.appSecret'), $_GET['code']);
//            dd($onedrive, $onedrive->getState());
//            dd($onedrive->getState());
//            //dd($onedrive->getState());
//            $tokenCache = new TokenCache();
//            $tokenCache->storeTokens($accessToken, $user);
//            Auth::user()->update(['onedrive_token' => $onedrive->getState()->token->data->access_token]);
//            Session::put("onedrive", $onedrive->getState());
//            Session::save();
//
//
//            return redirect("/admin/index/runonedrive?success");
//
//        } catch (\Exception $e) {
////            dd($e);
////            $status = sprintf('<p>Reason: <cite>%s</cite></p>', htmlspecialchars($e->getMessage()));
////            dd($status, $e);
////            dd((string) $e->getResponse()->getBody(),$e);
//            return redirect("/admin/index/pathwork?e=" . $e->getMessage());
//        }

        exit;
    }

    public function runonedrive(Request $request)
    {

        try {
            $tokenCache = new TokenCache();

            if ($type = $request->input("type")) {

                if ($type == 'shared') {
                    $graph = new Graph();
                    $graph->setAccessToken($tokenCache->getAccessToken(Auth::user()));

                    $onedrive = new Client(
                        config('azure.appId'),
                        $graph,
                        new GuzzleHttpClient()
                    );


                    $fetchShared = $onedrive->fetchShared();

                    return view("admin.onedrive.shared", ['shared' => (array)$fetchShared->data]);

                }
                if ($type == 'root') {
                    try {
                        $graph = new Graph();
                        $graph->setAccessToken($tokenCache->getAccessToken(Auth::user()));

                        $onedrive = new Client(
                            config('azure.appId'),
                            $graph,
                            new GuzzleHttpClient()
                        );


                        $fetchRoot = $onedrive->fetchRoot();
                        $driveItems = $fetchRoot->fetchDriveItems();

                    } catch (ClientException $ex) {

                    }

                    return view("admin.onedrive.root", ['shared' => $driveItems, 'onedrivec_cronjob' => $onedrive]);

                }


            }

            if ($id = $request->input("id")) {

                $graph = new Graph();
                $graph->setAccessToken($tokenCache->getAccessToken(Auth::user()));

                $onedrive = new Client(
                    config('azure.appId'),
                    $graph,
                    new GuzzleHttpClient()
                );
                $folder = $onedrive->fetchDriveItem($id);
                $driveItems = $onedrive->fetchDriveItems($id);

                //$driveItems = $folder->fetchDriveItems();
                return view("admin.onedrive.root", ['shared' => $driveItems, 'onedrivec_cronjob' => $onedrive]);

            }

            return view("admin.onedrive.all", []);


        } catch (\Exception $e) {
            /*  var_dump(Session::get('onedrivec_cronjob')) ;*/
//              dd($e);
            /*return ("<script> alert('".$e->getMessage()."'); window.location.href='/admin/index/pathwork';</script>");*/
        return redirect()->route('onedrive.pathwork')
            ->with('error', 'Error requesting access token')
            ->with('errorDetail', json_encode($e->getMessage()));
//            return redirect("/admin/index/pathwork?e=" . json_encode($e->getMessage()));
        }

    }

    public function getpath(Request $request)
    {

        $response = [
            'success' => false,
            'message' => "Có lỗi xảy ra khi lấy đường dẫn! Vui lòng <a href='" . route('onedrive.login') . "' target='_blank'>đăng nhập OneDrive</a> để tiếp tục",
        ];
        $tokenCache = new TokenCache();
        if ($request->isMethod("post")) {
            $user = Auth::user();

//            if (!Session::has('onedrivec_cronjob') || empty(Session::get('onedrivec_cronjob'))) {
            if (!$tokenCache->getAccessToken($user)) {
                $response = [
                    'success' => false,
                    'url' => route('onedrive.login'),
                    'code' => 'onedrivec_cronjob',
                    'message' => "Vui lòng <a href='" . route('onedrive.login') . "' target='_blank'>đăng nhập OneDrive</a> để tiếp tục",
                ];
                return response()->json($response);
            }
            $validator = Validator::make($request->all(), [
                "code" => "required",
                "mydate" => "required",
                "cid_customer" => "required",
                "cid_supplier" => "required",
                "name_docs" => "required",
            ], [
                "code.required" => "Vui lòng kiểm tra lại số phiếu.",
                "mydate.required" => "Vui lòng kiểm tra dữ liệu ngày.",
                "cid_customer.required" => "Vui lòng chọn Khách hàng.",
                "cid_supplier.required" => "Vui lòng Chọn nhà cung cấp.",
                "name_docs.required" => "Vui lòng Nhập tên trong hồ sơ.",
            ]);
            if ($validator->fails()) {
                return response()->json($validator->messages(), Response::HTTP_EXPECTATION_FAILED);
            }
            $dataFolder = 'DTDP';
            $ten_nhacungcap = $request->cid_supplier_name;
            $ten_khachhang = $request->cid_customer_name;
            $tentronghoso = $request->name_docs;
            $strSophieu = $request->code;
            $ngay = Carbon::createFromFormat('d/m/Y', $request->mydate);
            $str_Year = $ngay->year;
            $str_Month = $ngay->month;
            $is_error = false;
            $arrPath = array($ten_nhacungcap, $str_Year, $str_Month, $ten_khachhang, $tentronghoso, $strSophieu);
            $strPath = implode('/', $arrPath);

            try {

                if ($tokenCache->getAccessToken($user)) {
                    $graph = new Graph();
                    $graph->setAccessToken($tokenCache->getAccessToken($user));

                    $onedrive = new Client(
                        config('azure.appId'),
                        $graph,
                        new GuzzleHttpClient(),
                    );
                    $fetchRoot = $onedrive->getRoot();
                    $driveItems = $fetchRoot->getChildren();
                    $dtdpFolder = null;

                    foreach ($driveItems as $item) {
                        if ($item->name == $dataFolder) {
                            $dtdpFolder = $item;
                            break;
                        }
                    }

                    if (!$dtdpFolder) {
                        $dtdpFolder = $fetchRoot->createFolder($dataFolder, ['name_conflict_behavior', NameConflictBehavior::FAIL]);
                    }
                    $nhacungcapFolder = null;
                    foreach ($dtdpFolder->getChildren() as $dir) {
                        if ($dir->name == $ten_nhacungcap) {
                            $nhacungcapFolder = $dir;
                            break;
                        }
                    }
                    if (!$nhacungcapFolder) {
                        $nhacungcapFolder = $dtdpFolder->createFolder($ten_nhacungcap, ['name_conflict_behavior', NameConflictBehavior::FAIL]);
                    }

                    $yearFolder = null;
                    foreach ($nhacungcapFolder->getChildren() as $dir) {
                        if ($dir->name == $str_Year) {
                            $yearFolder = $dir;
                            break;
                        }
                    }
                    if (!$yearFolder) {
                        $yearFolder = $nhacungcapFolder->createFolder($str_Year, ['name_conflict_behavior', NameConflictBehavior::FAIL]);
                    }

                    $monthFolder = null;
                    foreach ($yearFolder->getChildren() as $dir) {
                        if ($dir->name == $str_Month) {
                            $monthFolder = $dir;
                            break;
                        }
                    }

                    if (!$monthFolder) {
                        $monthFolder = $yearFolder->createFolder($str_Month, ['name_conflict_behavior', NameConflictBehavior::FAIL]);
                    }

                    $khachhangFolder = null;
                    foreach ($monthFolder->getChildren() as $dir) {
                        if ($dir->name == $ten_khachhang) {
                            $khachhangFolder = $dir;
                            break;
                        }
                    }
                    if (!$khachhangFolder) {
                        $khachhangFolder = $monthFolder->createFolder($ten_khachhang, ['name_conflict_behavior', NameConflictBehavior::FAIL]);
                    }

                    $tentronghosoFolder = null;
                    foreach ($khachhangFolder->getChildren() as $dir) {
                        if ($dir->name == $tentronghoso) {
                            $tentronghosoFolder = $dir;
                            break;
                        }
                    }
                    if (!$tentronghosoFolder) {
                        $tentronghosoFolder = $khachhangFolder->createFolder($tentronghoso, ['name_conflict_behavior', NameConflictBehavior::FAIL]);
                    }

                    $sophieuFolder = null;
                    foreach ($tentronghosoFolder->getChildren() as $dir) {
                        if ($dir->name == $strSophieu) {
                            $sophieuFolder = $dir;
                            break;
                        }
                    }
                    if (!$sophieuFolder) {
                        $sophieuFolder = $tentronghosoFolder->createFolder($strSophieu, ['name_conflict_behavior', NameConflictBehavior::FAIL]);
                    }

//                    $oldPath = $dtdpFolder;
//                    foreach ($arrPath as $key => $path) {
//                        try {
//                            $oldPath = $oldPath->createFolder($path, ['name_conflict_behavior', NameConflictBehavior::FAIL]);
//                        } catch (ClientException  $ex) {
//                            $is_error = true;
////                            break;
//                        }
//
//                    }

                    if (!$is_error) {
                        $response = [
                            'success' => true,
                            'id' => $sophieuFolder->id,
                            'code' => 'onedrivec_cronjob',
                            'message' => "Đã thiết lập thư mục dữ liệu OneDrive thành công!",
                        ];

                    }

                }

            } catch (\Exception $e) {
                $is_error = true;
            }

            if ($is_error) {
                Artisan::call("cache:clear");
                Cache::flush();
                $tokenCache->clearTokens(Auth::user());
                Session::forget('onedrivec_cronjob');
            }
        }
        return response()->json($response);
    }

    //CRON JOB
    public function first()
    {
        //var_dump($this->config);exit;
        $tokenCache = new TokenCache();
        if ($tokenCache->getAccessToken(Auth::user())) {
            return redirect("/admin/index/three");
        }

        return redirect()->route('onedrive.login');


//        $OneDrive = new Client(
//            config('azure.appId'),
//            new Graph(),
//            new GuzzleHttpClient()
//        );
//
//        // Gets a log in URL with sufficient privileges from the OneDrive API.
//        $url = $OneDrive->getLogInUrl($this->scope, $this->config['ONEDRIVE_CALLBACK_URI'] . "/admin/index/second");
//
//
//        Session::put('onedrivec_cronjob', $OneDrive->getState());
//
//        Session::save();
//        return redirect($url);
//
//        exit;


    }

//    public function second()
//    {
//
//        //   var_dump( $_GET['code']);exit;
//        try {
//
//            $graph = new Graph();
//            $graph->setAccessToken(Session::get('onedrivec_cronjob')->token->data->access_token);
//
//            $onedrive = new Client(
//                config('azure.appId'),
//                $graph,
//                new GuzzleHttpClient()
//            );
//
//
//            $onedrive->obtainAccessToken(config('azure.appSecret'), $_GET['code']);
//            Session::put("onedrivec_cronjob", $onedrive->getState());
//            Session::save();
//
//
//            return redirect("/admin/index/three");
//
//        } catch (\Exception $e) {
//            return redirect("/admin/index/first");
//        }
//
//        exit;
//    }

    public function three()
    {
        $tokenCache = new TokenCache();

        try {
            $graph = new Graph();
            $graph->setAccessToken($tokenCache->getAccessToken(Auth::user()));

            $onedrive = new Client(
                config('azure.appId'),
                $graph,
                new GuzzleHttpClient()
            );


            $data = DTForms::where("approved", "1")->orderBy("id", "ASC")->limit(5)->get();
            // var_dump($data);exit;
            foreach ($data as $d) {

                if (!empty($d->path_work) && strpos($d->path_work, "folder.") !== false) {
                    $folder = $onedrive->fetchDriveItem($d->path_work);
                    if ($folder->isFolder()) {
                        $driveItems = $folder->fetchChildObjects();

                        if ((int)$d->name_number < count($driveItems) + 1) {
                            $TUpdate = DTForms::find($d->id);
                            $TUpdate->drive_item = count($driveItems);
                            $TUpdate->approved = '2';
                            $TUpdate->save();
                        }
                    }
                }
            }

            return 'success';

        } catch (\Exception $e) {
            echo($e->getMessage());
        }

    }

    public function openpath($id)
    {
        $tokenCache = new TokenCache();

        try {
            $graph = new Graph();
//            $graph->setAccessToken(Session::get('onedrivec_cronjob')->token->data->access_token);
            $graph->setAccessToken($tokenCache->getAccessToken(Auth::user()));
            $onedrive = new Client(
                config('azure.appId'),
                $graph,
                new GuzzleHttpClient()
            );

            $fetchRoot = $onedrive->getRoot();
            $folder = $onedrive->getDriveItemById($fetchRoot->parentReference->driveId, $id);
            return Redirect::to($folder->webUrl);

        } catch (\Exception $e) {
//            echo($e->getMessage());
        }

        return Redirect::back();
    }

    //AJAX
    public function ajaxone()
    {
        $tokenCache = new TokenCache();
        //var_dump($this->config);exit;
        if ($tokenCache->getAccessToken(Auth::user())) {
            return 'success<script>window.close()</script>   ';
        }

        $OneDrive = new Client(
            config('azure.appId'),
            new Graph(),
            new GuzzleHttpClient()
        );
        // Gets a log in URL with sufficient privileges from the OneDrive API.
        $url = $OneDrive->getLogInUrl($this->scope, $this->config['ONEDRIVE_CALLBACK_URI'] . "/admin/index/ajaxtwo");


        Session::put('onedrivec_cronjob', $OneDrive->getState());

        Session::save();
        return redirect($url);

        exit;


    }

    public function ajaxtwo()
    {

        //   var_dump( $_GET['code']);exit;
        try {
            $tokenCache = new TokenCache();
            $graph = new Graph();
            $graph->setAccessToken($tokenCache->getAccessToken(Auth::user()));

            $onedrive = new Client(
                config('azure.appId'),
                $graph,
                new GuzzleHttpClient()
            );

            $onedrive->obtainAccessToken(config('azure.appSecret'), $_GET['code']);
            Session::put('onedrivec_cronjob', $onedrive->getState());
            Session::save();


            return 'success<script>window.close()</script>';

        } catch (\Exception $e) {
            return 'error <script>window.close()</script>';
        }

        exit;
    }

    public function ajaxthree($id)
    {

        try {
            $tokenCache = new TokenCache();
            $graph = new Graph();
            $graph->setAccessToken($tokenCache->getAccessToken(Auth::user()));

            $onedrive = new Client(
                config('azure.appId'),
                $graph,
                new GuzzleHttpClient()
            );

            $TUpdate = DTForms::find($id);

            $id_folder = str_replace("folder.", "", $TUpdate->path_work);
            $count_total = $TUpdate->drive_item;

            if (!empty($id_folder)) {
                $folder = $onedrive->fetchDriveItem($id_folder);

                if ($folder->isFolder()) {
                    $driveItems = $folder->fetchDriveItems($folder->getId());

                    $count_total = count($driveItems);

                    $TUpdate->drive_item = $count_total;
                    if ((int)$TUpdate->name_number < ($count_total + 1)) {

                        $TUpdate->approved = '2';
                        $TUpdate->save();
                        return '100%';
                    }
                }
            }
            $percen = floor($count_total / $TUpdate->name_number * 100);
            if ($percen == 100) {
                return '99';
            }
            return $percen;

        } catch (\Exception $e) {
            echo($e->getMessage());
        }

    }


}
