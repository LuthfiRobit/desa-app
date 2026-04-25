<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        $profile = Profile::first();
        if (!$profile) {
            $profile = Profile::create([
                'village_name' => 'Sukorejo',
                'head_of_village_name' => '',
            ]);
        }
        return view('administrator.profildesa.index', compact('profile'));
    }

    public function update(Request $request)
    {
        $profile = Profile::first();

        $validator = Validator::make($request->all(), [
            'village_name' => 'required|string|max:255',
            'head_of_village_name' => 'required|string|max:255',
            'population' => 'nullable|integer',
            'area_size' => 'nullable|numeric',
            'hamlet_count' => 'nullable|integer',
            'head_of_village_img' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'org_chart_image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $data = $request->only([
            'village_name', 'head_of_village_name', 'head_of_village_msg', 
            'population', 'area_size', 'hamlet_count', 'vision', 'mission', 'history'
        ]);

        if ($request->hasFile('head_of_village_img')) {
            if ($profile->head_of_village_img) {
                Storage::disk('public')->delete($profile->head_of_village_img);
            }
            $data['head_of_village_img'] = $request->file('head_of_village_img')->store('profile', 'public');
        }

        if ($request->hasFile('org_chart_image')) {
            if ($profile->org_chart_image) {
                Storage::disk('public')->delete($profile->org_chart_image);
            }
            $data['org_chart_image'] = $request->file('org_chart_image')->store('profile', 'public');
        }

        $profile->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Profil desa berhasil diperbarui!'
        ]);
    }
}
