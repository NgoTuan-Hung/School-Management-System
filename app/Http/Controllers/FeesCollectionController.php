<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassModel;
use App\Models\User;
use App\Models\StudentAddFeesModel;
use App\Models\SettingModel;
use Stripe\Stripe;
use App\Exports\ExportCollectFees;
use Illuminate\Support\Facades\Auth;
use Session;
use Excel;

class FeesCollectionController extends Controller
{

    public function CollectFeesStudent(Request $request)
    {
       $student_id = Auth::user()->id;

       $data['getFees'] = StudentAddFeesModel::getFees($student_id);

       $getStudent = User::getSingleClass($student_id);
       $data['getStudent'] = $getStudent;

       $data['header_title'] = "Fees Collection";

       $data['paid_amount'] = StudentAddFeesModel::getPaidAmount(Auth::user()->id, Auth::user()->class_id);

       return view('student.my_fees_collection', $data);
    }

    public function CollectFeesStudentPayment(Request $request)
     {
        $getStudent = User::getSingleClass(Auth::user()->id);
        $paid_amount = StudentAddFeesModel::getPaidAmount(Auth::user()->id, Auth::user()->class_id);

        if(!empty($request->amount))
        {
            $RemaningAmount = $getStudent->amount - $paid_amount;
            if($RemaningAmount >= $request->amount)
            {
                $remaning_amount_user =  $RemaningAmount - $request->amount;

                $payment = new StudentAddFeesModel;        
                $payment->student_id   = Auth::user()->id;
                $payment->class_id     = Auth::user()->class_id;
                $payment->paid_amount  = $request->amount;
                $payment->total_amount = $RemaningAmount;
                $payment->remaning_amount = $remaning_amount_user;
                $payment->payment_type = $request->payment_type;
                $payment->remark = $request->remark;
                $payment->created_by = Auth::user()->id;                        
                $payment->save();

                $getSetting = SettingModel::getSingle();

                if($request->payment_type == 'Paypal')
                {
                    $query = array();
                    $query['business']      = $getSetting->paypal_email;
                    $query['cmd']           = '_xclick';
                    $query['item_name']     = "Student Fees";
                    $query['no_shipping']   = '1';
                    $query['item_number']   = $payment->id;
                    $query['amount']        = $request->amount;
                    $query['currency_code'] = 'USD';
                    $query['cancel_return'] = url('student/paypal/payment-error');
                    $query['return']        = url('student/paypal/payment-success');

                    $query_string = http_build_query($query);

                    // header('Location: https://www.paypal.com/cgi-bin/webscr?' . $query_string);
                    header('Location: https://www.sandbox.paypal.com/cgi-bin/webscr?' . $query_string);
                    exit();
                }
                else if($request->payment_type == 'Stripe')
                {
                    $setPublicKey   = $getSetting->stripe_key;   
                    $setApiKey      = $getSetting->stripe_secret;   
                    
                    Stripe::setApiKey($setApiKey);
                    $finalprice = $request->amount * 100;
                                        
                    $session = \Stripe\Checkout\Session::create([
                        'customer_email' => Auth::user()->email,
                        'payment_method_types' => ['card'],
                        'line_items'    => [[
                            'name'      => 'Student Fees',
                            'description' => 'Student Fees',
                            'images'    => [url('public/dist/img/user2-160x160.jpg') ],
                            'amount'    => intval($finalprice),
                            'currency'  => 'INR',
                            'quantity'  => 1,
                        ]],
                        'success_url' => url('student/stripe/payment-success'),
                        'cancel_url' => url('student/stripe/payment-error'),
                    ]);

                    
                    $payment->stripe_session_id = $session['id'];
                    $payment->save();

                    $data['session_id']   = $session['id'];
                    Session::put('stripe_session_id', $session['id']);
                    $data['setPublicKey'] = $setPublicKey;

                    return view('stripe_charge', $data);
                }
            }
            else
            {
                return redirect()->back()->with('error', "Your amount go to greather than remaning amount");
            }
        }
        else
        {
            return redirect()->back()->with('error', "You need add your amount atleast $1");
        } 

     }
    

     
}
