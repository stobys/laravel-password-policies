
<?php

namespace SylveK\LaravelPasswordPolicies;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class PasswordHistory extends Model
{
    protected $fillable = ['user_id', 'password', 'created_by'];
	protected $depth = 
	
	// -- PasswordHistory constructor.
    public function __construct(array $attributes = [])
    {
        $this->table = config('password-history.table', 'password_histories');
        parent::__construct($attributes);
    }

	// -- Store Current Password Into History
    public static function storeCurrentPasswordInHistory($password, $user = null)
    {
		$user = self::getUser($user);
		
        PasswordHistory::create(get_defined_vars());
    }
	
	// -- Fetch users pasword history
    public static function fetchHistory($depth = null, $user = null)
    {
		$depth = $depth ?: config('password-policies.password_history_depth', 5);
		$user_id = self::getUser($user) -> id;
		
        return self::where('user_id', $user_id)
				-> latest() -> take($depth)
				-> get();
    }
	
	public static function getUser( $user = null )
		if ( is_null( $user ) )
		{
			return auth() -> user();
		}
		
		if ( is_int($user) )
		{
			return User::findOrFail($user);
		}
	
		if ( $user instanceof Model )
		{
			return $user;
		}
		
	{
		
}
