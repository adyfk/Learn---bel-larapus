<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;
use App\Book;
use App\BorrowLog;
use App\Exceptions\BookException;
use Illuminate\Support\Facades\Mail;
use App\Exceptions\MemberException;
class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $casts = [
        'is_verified' => 'boolean',
        ];        
    public function hapus(){
        $cek = borrowLog::where('user_id',$this->id)->where('is_returned', 1)->count();
        if($cek > 0){
            throw new MemberException("Masih Ada $cek Buku Yang di Pinjam Oleh '$this->name'.");
        }   
        if($this->hasRole('member')){
           $this->delete();
        }
        return $this;
    }
    public function borrow(Book $book)
    {
        // cek apakah masih ada stok buku
        if($book->stock < 1) {
            throw new BookException("Buku $book->title sedang tidak tersedia.");
        }   
        // cek apakah buku ini sedang dipinjam oleh user
        if($this->borrowLogs()->where('book_id',$book->id)->where('is_returned', 0)->count() > 0 ) {
            throw new BookException("Buku $book->title sedang Anda pinjam.");
        }
        $borrowLog = BorrowLog::create(['user_id'=>$this->id, 'book_id'=>$book->id]);
        return $borrowLog;
    }
    public function borrowLogs()
    {
        return $this->hasMany('App\BorrowLog');
    }
    public function sendVerification(){
        $token = $this->generateVerificationToken();
        $user = $this;
        Mail::send('auth.emails.verification', compact('user', 'token'), function ($m) use ($user){ 
            $m->to($user->email, $user->name)->subject('Verifikasi Akun Larapus');
        });
    }
    public function verify()
    {
       $this->is_verified = 1;
        $this->verification_token = null;
        $this->save();
    }
    public function generateVerificationToken() 
    {
        $token = $this->verification_token;
        if (!$token) {
            $token = str_random(40);
            $this->verification_token = $token;
            $this->save();
        }
        return $token;
    }




    
}
