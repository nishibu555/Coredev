<?php


namespace Repository\User;


use App\Models\Conversation\Conversation;
use App\Models\User\Profile;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Response;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Repository\Repository;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserRepository extends Repository
{

    public function model()
    {
        return User::class;
    }

    public function registerUser(array $data): User
    {
        return DB::transaction(
            function () use ($data) {
                $user = $this->model()::updateOrCreate(
                    [
                        'email' => $data['email'],
                        'password' => null
                    ],
                    [
                        'first_name' => $data['first_name'],
                        'last_name' => $data['last_name'],
                        'email' => $data['email'],
                        'phone' => $data['phone'],
                        'password' => bcrypt($data['password']),
                        'is_active' => 1
                    ]
                );

                $user->profile()->updateOrCreate(['user_id' => $user->id], ['dob' => $data['dob'] ?? null, 'gender' => $data['gender'] ?? null]);

                return $user;
            }
        );
    }

    public function search($query = '', $page = 1, $perPage = 30)
    {
        $users = $this->model()::query();
        if (!empty($query)) {
            $users->where('first_name', 'like', "%{$query}%")
                ->orWhere('last_name', 'like', "%{$query}%")
                ->orWhere('phone', 'like', "%{$query}%")
                ->orWhere('email', 'like', "%{$query}%");
        }
        $users = $users->paginate($perPage);
        return $users;
    }

    public function searchWithRelation($query = '', $perPage = 30, $page = 1)
    {
        $users = $this->model()::query();
        if (!empty($query)) {
            $users->where('first_name', 'like', "%{$query}%")
                ->orWhere('last_name', 'like', "%{$query}%")
                ->orWhere('phone', 'like', "%{$query}%")
                ->orWhere('email', 'like', "%{$query}%");
        }
        $users->with(['connections' => function($connection) {
            $connection->where('connected_user_id', auth()->id());
        }]);
        $users = $users->get();
        $connectedUsers = $users->filter(function ($user) {
            return $user->connections->count() > 0;
        });

        $nonConnectedUsers = $users->filter(function ($user) {
            return $user->connections->count() < 1;
        });
        $users = $connectedUsers->merge($nonConnectedUsers);

        return $users->paginate($perPage);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->model()::where('email', $email)->first();
    }

    public function findActiveByPhone(string $phone): ?User
    {
        return $this->model()::where('phone', $phone)->active()->first();
    }

    public function findByPhone($phone)
    {
        return $this->model()::where('phone', $phone)->first();
    }

    public function withWishes(User $user)
    {
        return $user->load('wishes');
    }

    public function getAnotherUserFrom(Conversation $conversation)
    {
        $user = $conversation->users->where('id', '!=', auth()->id())->first();
        return $this->withWishes($user);
    }

    public function deleteUserByEmailOrPhone($emailOrPhone)
    {
        $user = $this->model()::where('email', $emailOrPhone)
            ->orWhere('phone', $emailOrPhone)
            ->firstOrFail();

        optional($user)->socialAccounts()->delete();
        return $user->delete();
    }

    public function findActiveByEmailOrPhone(string $emailOrPhone)
    {
        $user = $this->model()::where(function (Builder $builder) use ($emailOrPhone) {
            return $builder->where('email', $emailOrPhone)->orWhere('phone', $emailOrPhone);
        })->first();

        if ($user && !$user->is_active) {
            throw new HttpException(Response::HTTP_BAD_REQUEST, 'You are not an active user. Please talk to our customer service for further information!');
        }

        return $user;
    }

    public function getAccessToken(User $user): array
    {
        $token = $user->createToken('user token');
        return [
            'auth_type' => 'Bearer',
            'token' => $token->accessToken,
            'expires_at' => $token->token->expires_at->format('Y-m-d H:i:s'),
        ];
    }

    public function getUsersByCheckingIds($ids)
    {
       return $this->model()::whereIn('id', $ids)->get();
    }

    public function getPeopleMayKnow($userIds, Profile $userProfile)
    {
        $users = $this->model()::query();
        $nonConnectedUsers = $users->whereNotIn('id', $userIds);
        if (!empty($nonConnectedUsers)) {
            $nonConnectedUsers->whereHas('profile', function($profile) use ($userProfile) {
                $profile->where('religion', 'like', $userProfile->religion ? "%$userProfile->religion%" : '')
                    ->orWhere('interests', 'like', $userProfile->interests ? "%$userProfile->interests%" : '')
                    ->orWhere('hobbies', 'like', $userProfile->hobbies ? "%$userProfile->hobbies%" : '')
                    ->orWhere('preferred_language', 'like', $userProfile->preferred_language ?"%$userProfile->preferred_language%" : '');

            });
        }

        return $nonConnectedUsers->get();
    }
}
