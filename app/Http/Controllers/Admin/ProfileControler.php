<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\worker;
use Illuminate\Support\Facades\DB;

class ProfileControler extends Controller
{
    public function dashboard()
    {
        $dashNumbers['experts'] = 450;
        $dashNumbers['vendors'] = 450;
        $dashNumbers['totalOrdersToday'] = 450;
        $dashNumbers['totalStocksToday'] = 450;

        $workers = 50;

        return view('adminPages.dashboard', [
            'title' => 'AdminPortal |  Dashboard | ',
            'dashNumbers' => $dashNumbers,
            'workers' => $workers,
            // 'alertDescription' => '',
            // 'alertTitle' => 'Cusomer Number Already Exists in our Record.',
            // 'alertIcon' => 'success'
        ]);
    }

    public function viewVendors()
    {
        $workers = worker::select()->get();
        // return response()->json(['allVendors'=>$allVendors], 200);
        $result = [];

        foreach ($workers as $worker) {
            $disc = $worker->job_disc;
            $preliminaryCheckup = "No";
            if (!empty($disc) && is_string($disc)) {
                $data_array = json_decode($disc, true);
                if (is_array($data_array) && array_key_exists('Preliminary Check Up', $data_array)) {
                    $variable = $data_array['Preliminary Check Up'];
                    if ($variable) {
                        $preliminaryCheckup = "Yes";
                    } else {
                        $preliminaryCheckup = "No";
                    }
                } else {
                    $preliminaryCheckup = "No";
                }
            } else {
                $preliminaryCheckup = "No";
            }

            $json = $worker->area;
            $locations = [];

            if (!is_null($json) && !empty(json_decode($json))) {
                $decoded = json_decode($json, true);
                foreach ($decoded as $item) {
                    if (isset($item['location']) && isset($item['bool']) && $item['bool']) {
                        $locations[] = $item['location'];
                    }
                }
            }
            $location_string = implode(', ', $locations);

            $brandData = $worker->brand;
            $brands = [];

            if ($brandData) {
                $data = json_decode($brandData, true);
                foreach ($data as $item) {
                    if ($item['bool']) {
                        $brands[] = $item['brand'];
                    }
                }
            }

            $brandName = implode(", ", $brands);

            $modelJson = $worker->model;
            if ($modelJson) {
                $models = json_decode($modelJson, true);
                $modelNames = array_reduce($models, function ($acc, $model) {
                    if ($model['bool'] === true) {
                        $acc[] = $model['model'];
                    }
                    return $acc;
                }, []);
                $modelNamesStr = implode(", ", $modelNames);
            } else {
                $modelNamesStr = "N/A";
            }

            if ($worker->address != '') {
                $address = $worker->address;
            } else {
                $address = "NA";
            }

            $result[] = [
                'id' => $worker->id,
                'personalDetails' => nl2br("Name: $worker->name\n$worker->email\n $worker->phone_no\n Address: $address"),
                // 'address' => nl2br("$worker->address<br>$worker->city $worker->state<br>$worker->country $worker->pincode"),
                'bankDetails' => nl2br("Account Number: $worker->account_no\nAccount Holder Name: $worker->accholder_name\nBank Name: $worker->bank_name\nBranch Name: $worker->branch_name\nIFSC Code: $worker->ifsc_code"),
                'businessDetails' => nl2br("PAN: $worker->pan_no\nName: $worker->name_pan\nGST: $worker->gst_no\nName: $worker->gst_name"),
                'businessPresence' => nl2br("Role: $worker->job\nPI: $preliminaryCheckup"),
                'preferedArea' => nl2br("$location_string"),
                'brand' => nl2br("$brandName"),
                'models' => nl2br("$modelNamesStr"),
                'is_active' => $worker->is_active,

            ];
        }

        // return json_encode($workers);

        return view('adminPages.viewVendors', [
            'title' => 'AdminPortal | View Vendor',
            'workers' => $result,
        ]);
    }

    public function sendnotification()
    {
        $workers = DB::table('workers')->get();
        // return response()->json(['allVendors'=>$allVendors], 200);

        return view('adminPages.sendNotifications', [
            'title' => 'AdminPortal | Send Notification',
        ]);
    }

    private function extractTrueValues($json, $key)
    {
        // Convert the JSON data into a PHP array
        $data = json_decode($json, true);

        // Check if the key exists in the data
        if (!isset($data[$key])) {
            return [];
        }

        // Loop through the object and extract the values that are true
        $trueValues = [];
        foreach ($data[$key] as $key => $value) {
            if ($value) {
                $trueValues[] = $key;
            }
        }

        // Output the true values
        return $trueValues;
    }

    public function suspendVendor($id)
    {
        $worker = worker::find($id);
        $worker->is_active = 0;
        $worker->save();

        return redirect()->back()->with('message', 'Vendor Suspended Successfully');
    }

    public function reviveVendor($id)
    {
        $worker = worker::find($id);
        $worker->is_active = 1;
        $worker->save();

        return redirect()->back()->with('message', 'Vendor Activated Successfully');
    }

}
