<?php

namespace ChatBox\Models;

use ChatBox\Models\Status;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;


class User extends Model implements AuthenticatableContract {
    use Authenticatable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'first_name',
        'last_name',
        'location'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];


    /*
     * Get Name helper functions
     */
    public function getName(){

        if($this->first_name && $this->last_name){
            return "{$this->first_name} {$this->last_name}";
        }

        if ($this->first_name){
            return $this->first_name;
        }

        return null;
    }

    // Get Name or Username
    public function getNameOrUsername(){
        return $this->getName() ?: $this->username;
    }

    // Get First Name or Username
    public function getFirstNameOrUsername(){
        return $this->first_name ?: $this->username;
    }

    // Avatar
    public function getAvatarURL(){
		return "https://www.gravatar.com/avatar/{{ md($this->email) }}?d=mm&s=80";
    }

    // Relationship with Friends table
    public function friendsOfMine(){
        return $this->belongsToMany('ChatBox\Models\User', 'friends', 'user_id', 'friend_id');
    }

    public function friendOf(){
        return $this->belongsToMany('ChatBox\Models\User', 'friends', 'friend_id', 'user_id');
    }

    public function friends(){
        return $this->friendsOfMine()
            ->wherePivot('accepted', true)
            ->get()
            ->merge($this->friendOf()
            ->wherePivot('accepted', true)
            ->get());
    }

    // Friend request handling
    public function friendRequests(){
        return $this->friendsOfMine()
            ->wherePivot('accepted', false)
            ->get();
    }

    public function friendRequestsPending(){
        return $this->friendOf()
            ->wherePivot('accepted', false)
            ->get();
    }

    public function hasFriendRequestPending(User $user){
        return (bool) $this->friendRequestsPending()->where('id', $user->id)->count();
    }

    public function hasFriendRequestReceived(User $user){
        return (bool) $this->friendRequests()
            ->where('id', $user->id)->count();
    }

    public function addFriend(User $user){
        $this->friendOf()->attach($user->id);
    }

    public function acceptFriendRequest(User $user){
        $this->friendRequests()->where('id', $user->id)->first()
        ->pivot
        ->update([
            'accepted'  =>  true,
        ]);
    }

    public function isFriendsWith(User $user){
        return (bool) $this->friends()->where('id', $user->id)->count();
    }

    // Statuses

    public function statuses(){
        return $this->hasMany('ChatBox\Models\Status', 'user_id');
    }

    // Like Status

    // Creates Like Relationship with User
    public function likes(){

        return $this->hasMany('ChatBox\Models\Like', 'user_id');

    }

    // Checks if user has already liked a particular status
    public function hasLikedStatus(Status $status){

        return (bool) $status
            ->likes()
            ->where('user_id', $this->id)
            ->count();

    }

}
