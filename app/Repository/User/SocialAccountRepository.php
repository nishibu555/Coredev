<?php


namespace App\Repository\User;


use App\Models\Media;
use App\Models\User\SocialAccount;
use App\Models\User\User;
use App\Repository\MediaRepository;
use Repository\Repository;
use Repository\User\UserRepository;
use \Laravel\Socialite\AbstractUser as ProviderUser;

class SocialAccountRepository extends Repository
{

    /**
     * @var UserRepository
     */
    protected $userRepo;

    /**
     * @inheritDoc
     */
    public function model()
    {
        return SocialAccount::class;
    }

    public function findOrCreate(ProviderUser $providerUser, $providerName, $providerId): User
    {
        $this->userRepo = app(UserRepository::class);

        $socialAccount = $this->model()::where('provider_name', $providerName)
            ->where('provider_id', $providerId)
            ->first();

        if ($socialAccount) {
            return $socialAccount->user;
        }

        if ($email = $providerUser->getEmail()) {
            $user = $this->userRepo->findByEmail($email);
        }

        switch($providerName)
        {
            case 'facebook':
                $first_name = $providerUser->offsetGet('first_name');
                $last_name = $providerUser->offsetGet('last_name');
                break;

            case 'google':
                $first_name = $providerUser->offsetGet('given_name');
                $last_name = $providerUser->offsetGet('family_name');
                break;

            default:
                $fullName = $this->getFullName($providerUser->getName());
                $first_name = $fullName['first_name'];
                $last_name = $fullName['last_name'];
        }

        if (!isset($user)) {
            $user = $this->userRepo->create([
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
            ]);

            $this->saveProfilePhoto($user, $providerUser);
        }

        $user->socialAccounts()->create([
            'provider_id' => $providerId,
            'provider_name' => $providerName,
        ]);

        return $user;
    }

    private function getFullName($name)
    {
        $name = trim($name);
        $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
        $first_name = trim( preg_replace('#'.$last_name.'#', '', $name ) );

        return [
            'first_name' => $first_name,
            'last_name' => $last_name
        ];
    }

    private function saveProfilePhoto(User $user, $providerUser)
    {
        $photoPath = $providerUser->getAvatar();
        $extension = pathinfo($photoPath, PATHINFO_EXTENSION);

        $user->profilePhoto()->associate(
            (new MediaRepository())->create([
                'title' => "Photo of user: $user->name($user->id)",
                'src' => $photoPath,
                'extension' => $extension,
                'type' => 'image',
            ])
        );
        $user->save();
    }
}
