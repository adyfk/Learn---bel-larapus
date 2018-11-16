<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\User;
use Yajra\DataTables\Html\Builder;
use DataTables;
use App\Http\Requests\StoreMemberRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Hash;
use App\Http\Requests\UpdateMemberRequest;
use App\Exceptions\MemberException;
class MembersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        if (request()->ajax()) {
            $members = Role::where('name', 'member')->first()->users;
            return DataTables::of($members)
            ->editColumn('name', function($member) {
                return '<a href="'.route('members.show', $member->id).'">'.$member->name.'</a>'; })
            ->addColumn('action', function($member){
                return view('members._action', [
                    'model' => $member,
                    'form_url' => route('members.destroy', $member->id),
                    'edit_url' => route('members.edit', $member->id),
                    'confirm_message' => 'Yakin mau menghapus ' . $member->name . '?'                    
                ]);
            })
            ->rawColumns(['name','action'])     //untuk Kolom yang memiliki HTML
            ->make(true);
        }        
        $html = $builder->columns([
                ['data' => 'name', 'name'=>'name', 'title'=>'Nama'],
                ['data' => 'email', 'name'=>'email', 'title'=>'Email'],
                ['data' => 'action', 'name'=>'action', 'title'=>'', 'orderable'=>false,'\searchable'=>false]
            ]);
        return view('members.index', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('members.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMemberRequest $request)
    {
        $password = str_random(6);
        $data = $request->all();
        $data['password'] = Hash::make($password);
        $member = User::create($data);
        $member->verify();
        // set role
        $memberRole = Role::where('name', 'member')->first();
        $member->attachRole($memberRole);
        // kirim email
        Mail::send('auth.emails.invite', compact('member', 'password'), function ($m) use ($member) {
            $m->to($member->email, $member->name)->subject('Anda telah didaftarkan di Larapus!');
        });
        Session::flash("flash_notification", [
            "level" => "success",
            "message" => "Berhasil menyimpan member dengan email " .
            "<strong>" . $data['email'] . "</strong>" .
            "dan password <strong>" . $password . "</strong>."
        ]);
        return redirect()->route('members.index');
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $member = User::find($id);
        return view('members.show', compact('member'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMemberRequest $request, $id)
    {
        $member = User::find($id);
        $member->update($request->only('name','email'));
        Session::flash("flash_notification", [
            "level"=>"success",
            "message"=>"Berhasil menyimpan $member->name"
        ]);
        return redirect()->route('members.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $cek = User::find($id);
            $cek->hapus();
            Session::flash("flash_notification", [
                "level"=>"success",
                "message"=>"Berhasil menghapus $member->name"
            ]);
        }catch(MemberException $e){
            Session::flash("flash_notification", [
            "level" => "danger",    
            "message" => $e->getMessage()." Lihat <a href=".route('members.show',$id)."> DI SINI </a> "
            ]);
        }
        return redirect()->route('members.index');
    }
}
