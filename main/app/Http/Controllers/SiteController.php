<?php

namespace App\Http\Controllers;

use App\Models\AdminNotification;
use App\Models\Epin;
use App\Models\Frontend;
use App\Models\Page;
use App\Models\SupportAttachment;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;


class SiteController extends Controller
{
    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
    }


    public function CheckSponsor(Request $request)
    {
        $id = User::where('sponsor_id', $request->sponsor)->first();
        // if($id ) {
        //     return response()->json(['status' => 'success', 'message' => 'Sponsor ID is valid']);
        // } else {
        //     return response()->json(['status' => 'error', 'message' => 'Sponsor ID is invalid']);
        // }
        if ($id == '') {
            return response()->json(['success' => false, 'msg' => "<span class='help-block'><strong class='text-danger'>Sponsor ID not found</strong></span>"]);
        } else {
            return response()->json(['success' => true, 'msg' => "<span class='help-block'><strong class='text-success'>$id->fullname</strong></span>
                     <input type='hidden' id='sponsor_ref_id' value='$id->id' name='sponsor_ref_id'>"]);
        }
    }

    public function CheckPlacer(Request $request)
    {
        $id = User::where('placer_id', $request->placer)->first();

        if ($id == '') {
            return response()->json(['success' => false, 'msg' => "<span class='help-block'><strong class='text-danger'>Placer ID not found</strong></span>"]);
        } else {
            return response()->json(['success' => true, 'msg' => "<span class='help-block'><strong class='text-success'>$id->username</strong></span>
                     <input type='hidden' id='placer_ref_id' value='$id->id' name='placer_ref_id'>"]);
        }
    }

    public function CheckEpin(Request $request)
    {
        $id = Epin::where('epin', $request->epin)->first();

        if ($id == '') {
            return response()->json(['success' => false, 'msg' => "<span class='help-block'><strong class='text-danger'>Epin not found</strong></span>"]);
        } else if ($id->status == 1) {
            return response()->json(['success' => false, 'msg' => "<span class='help-block'><strong class='text-danger'>Epin already used</strong></span>"]);
        } else {
            return response()->json(['success' => true, 'msg' => "<span class='help-block'><strong class='text-success'>Epin is valid</strong></span>
                     <input type='hidden' id='epin_ref' value='$id->epin' name='epin_ref'>"]);
        }
    }

    public function userPosition(Request $request)
    {
        // dd($request->all());

        if (!$request->referrer) {
            return response()->json(['success' => false, 'msg' => "<span class='help-block'><strong class='text-danger'>Enter Sponsor ID first</strong></span>"]);
        }
        if (!$request->position) {
            return response()->json(['success' => false, 'msg' => "<span class='help-block'><strong class='text-danger'>Select your position*</strong></span>"]);
        }
        $user = User::find($request->referrer);

        $pos = getPosition($user->id, $request->position);
        $join_under = User::find($pos['pos_id']);
        // check if user has left or right position already or not
        if ($pos['position'] == 1) {
            if ($user->left_side != 0) {
                return response()->json(['success' => false, 'msg' => "<span class='help-block'><strong class='text-danger'>This user already have a left position</strong></span>"]);
            }
        } else {
            if ($user->right_side != 0) {
                return response()->json(['success' => false, 'msg' => "<span class='help-block'><strong class='text-danger'>This user already have a right position</strong></span>"]);
            }
        }

        if ($pos['position'] == 1)
            $position = 'Left';
        else {
            $position = 'Right';
        }
        return response()->json(['success' => true, 'msg' => "<span class='help-block'><strong class='text-success'>Your are joining under $join_under->username at $position  </strong></span>"]);
    }

    public function placeholderImage($size = null)
    {
        if ($size != 'undefined') {
            $size = $size;
            $imgWidth = explode('x', $size)[0];
            $imgHeight = explode('x', $size)[1];
            $text = $imgWidth . '×' . $imgHeight;
        } else {
            $imgWidth = 150;
            $imgHeight = 150;
            $text = 'Undefined Size';
        }
        $fontFile = realpath('assets/font') . DIRECTORY_SEPARATOR . 'RobotoMono-Regular.ttf';
        $fontSize = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if ($imgHeight < 100 && $fontSize > 30) {
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 100, 100, 100);
        $bgFill    = imagecolorallocate($image, 175, 175, 175);
        imagefill($image, 0, 0, $bgFill);
        $textBox = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }
    public function index()
    {
        $count = Page::where('tempname', $this->activeTemplate)->where('slug', 'home')->count();
        if ($count == 0) {
            $page = new Page();
            $page->tempname = $this->activeTemplate;
            $page->name = 'HOME';
            $page->slug = 'home';
            $page->save();
        }

        $data['page_title'] = 'Home';
        $data['sections'] = Page::where('tempname', $this->activeTemplate)->where('slug', 'home')->firstOrFail();
        // dd($data);
        return view($this->activeTemplate . 'home', $data);
    }

    public function pages($slug)
    {
        $page = Page::where('tempname', $this->activeTemplate)->where('slug', $slug)->firstOrFail();
        $data['page_title'] = $page->name;
        $data['sections'] = $page;
        return view($this->activeTemplate . 'pages', $data);
    }


    public function contact()
    {
        $data['page_title'] = "Contact Us";
        $data['contact'] = Frontend::where('data_keys', 'contact_us.content')->first();
        $data['sections'] = Page::where('tempname', $this->activeTemplate)->where('slug', 'contact')->firstOrFail();
        return view($this->activeTemplate . 'contact', $data);
    }


    public function blog()
    {
        $data['page_title'] = "Blog";
        $data['blogs'] = Frontend::where('data_keys', 'blog.element')->latest()->paginate(getPaginate());
        $page = Page::where('tempname', $this->activeTemplate)->where('slug', 'blog')->firstOrFail();
        $data['page_title'] = $page->name;
        $data['sections'] = $page;
        return view(activeTemplate() . 'blog', $data);
    }

    public function singleBlog($slug, $id)
    {
        $data['blog'] = Frontend::where('data_keys', 'blog.element')->where('id', $id)->firstOrFail();
        $data['latestBlogs'] = Frontend::where('id', '!=', $id)->where('data_keys', 'blog.element')->take(5)->get();
        $data['page_title'] = "Details";
        return view(activeTemplate() . 'blogDetails', $data);
    }

    // policy page
    public function policyDetails()
    {
        $data['page_title'] = "Policy";
        $data['sections'] = Frontend::where('data_keys', 'policy_pages.element')->firstOrFail();
        return view(activeTemplate() . 'policy', $data);
    }

    public function contactSubmit(Request $request)
    {
        $ticket = new SupportTicket();
        $message = new SupportMessage();

        $imgs = $request->file('attachments');
        $allowedExts = array('jpg', 'png', 'jpeg', 'pdf');

        $this->validate($request, [
            'attachments' => [
                'sometimes',
                'max:4096',
                function ($attribute, $value, $fail) use ($imgs, $allowedExts) {
                    foreach ($imgs as $img) {
                        $ext = strtolower($img->getClientOriginalExtension());
                        if (($img->getSize() / 1000000) > 2) {
                            return $fail("Images MAX  2MB ALLOW!");
                        }
                        if (!in_array($ext, $allowedExts)) {
                            return $fail("Only png, jpg, jpeg, pdf images are allowed");
                        }
                    }
                    if (count($imgs) > 5) {
                        return $fail("Maximum 5 images can be uploaded");
                    }
                },
            ],
            'name' => 'required|max:191',
            'email' => 'required|max:191',
            'subject' => 'required|max:100',
            'message' => 'required',
        ]);


        $random = getNumber();

        $ticket->user_id = auth()->id();
        $ticket->name = $request->name;
        $ticket->email = $request->email;


        $ticket->ticket = $random;
        $ticket->subject = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status = 0;
        $ticket->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = auth()->id() ? auth()->id() : 0;
        $adminNotification->title = 'New support ticket has opened';
        $adminNotification->click_url = route('admin.ticket.view', $ticket->id);
        $adminNotification->save();

        $message->support_ticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();

        $path = imagePath()['ticket']['path'];

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $image) {
                try {
                    $attachment = new SupportAttachment();
                    $attachment->support_message_id = $message->id;
                    $attachment->image = uploadImage($image, $path);
                    $attachment->save();
                } catch (\Exception $exp) {
                    $notify[] = ['error', 'Could not upload your ' . $image];
                    return back()->withNotify($notify)->withInput();
                }
            }
        }
        $notify[] = ['success', 'ticket created successfully!'];

        return redirect()->route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }
}
