<?php

$dir = __DIR__ . '/app/Models/';

// Locality
file_put_contents($dir . 'Locality.php', "<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Locality extends Model
{
    protected \$fillable = ['name', 'zone_id', 'city', 'state', 'pincode', 'lat', 'lng'];

    public function zone() { return \$this->belongsTo(Zone::class); }
    public function societies() { return \$this->hasMany(Society::class); }
    public function users() { return \$this->hasMany(User::class); }
    public function incidents() { return \$this->hasMany(Incident::class); }
}");

// Society
file_put_contents($dir . 'Society.php', "<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Society extends Model
{
    protected \$fillable = ['name', 'locality_id', 'type', 'landmark', 'lat', 'lng'];

    public function locality() { return \$this->belongsTo(Locality::class); }
    public function users() { return \$this->hasMany(User::class); }
    public function incidents() { return \$this->hasMany(Incident::class); }

    public function getFullNameAttribute()
    {
        return \$this->name . ', ' . \$this->locality->name;
    }
}");

// Poll
file_put_contents($dir . 'Poll.php', "<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    protected \$fillable = ['zone_id', 'user_id', 'question', 'expires_at', 'is_active'];
    protected \$casts = ['expires_at' => 'datetime', 'is_active' => 'boolean'];

    public function zone() { return \$this->belongsTo(Zone::class); }
    public function user() { return \$this->belongsTo(User::class); }
    public function options() { return \$this->hasMany(PollOption::class); }
    public function votes() { return \$this->hasMany(PollVote::class); }

    public function getResults()
    {
        \$totalVotes = \$this->votes()->count();
        if (\$totalVotes === 0) return [];
        
        return \$this->options->map(function (\$option) use (\$totalVotes) {
            \$votes = \$option->votes()->count();
            return [
                'id' => \$option->id,
                'text' => \$option->option_text,
                'votes' => \$votes,
                'percentage' => round((\$votes / \$totalVotes) * 100)
            ];
        });
    }
}");

// PollOption
file_put_contents($dir . 'PollOption.php', "<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PollOption extends Model
{
    protected \$fillable = ['poll_id', 'option_text'];

    public function poll() { return \$this->belongsTo(Poll::class); }
    public function votes() { return \$this->hasMany(PollVote::class); }
}");

// PollVote
file_put_contents($dir . 'PollVote.php', "<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PollVote extends Model
{
    protected \$fillable = ['poll_id', 'poll_option_id', 'user_id'];

    public function poll() { return \$this->belongsTo(Poll::class); }
    public function option() { return \$this->belongsTo(PollOption::class, 'poll_option_id'); }
    public function user() { return \$this->belongsTo(User::class); }
}");

// Kudo
file_put_contents($dir . 'Kudo.php', "<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kudo extends Model
{
    protected \$fillable = ['giver_id', 'receiver_id', 'incident_id', 'message'];

    public function giver() { return \$this->belongsTo(User::class, 'giver_id'); }
    public function receiver() { return \$this->belongsTo(User::class, 'receiver_id'); }
    public function incident() { return \$this->belongsTo(Incident::class); }
}");

echo "Models created successfully!\n";
