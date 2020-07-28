<?php


namespace Repository\User;


use App\Events\UserRegistered;
use App\Models\User\User;
use App\Models\User\VerificationCode;
use Illuminate\Http\Response;
use Repository\Repository;
use Symfony\Component\HttpKernel\Exception\HttpException;

class VerificationCodeRepository extends Repository
{
    public function model()
    {
        return VerificationCode::class;
    }


    public function storeCodeFor(User $user, $purpose = 'phone'): VerificationCode
    {
        return $this->create([
            'user_id' => $user->id,
            'subject' => $user->{$purpose},
            'purpose' => $purpose,
            'token' => $this->generateUniqueToken(),
            'code' => $this->generateCode(),
            'expires_at' => now()->addMinutes(3),
        ]);
    }

    public function markAsVerified(VerificationCode $verifyCode)
    {
        $verifiedAt = $verifyCode->purpose . '_verified_at';
        $verifyCode->user->update([$verifiedAt => now()]);
        return $verifyCode->update(['verified_at' => now()]);
    }

    public function findOrFailByToken(string $token): VerificationCode
    {
        return $this->model()::where('token', $token)->firstOrFail();
    }

    public function checkCode(string $token, string $code): VerificationCode
    {
        $verificationCode = $this->findOrFailByToken($token);

        if (!is_null($verificationCode->verified_at)) {
            throw new HttpException(Response::HTTP_BAD_REQUEST, 'Already verified');
        }

        if ($verificationCode->code != $code) {
            throw new HttpException(Response::HTTP_BAD_REQUEST, 'Invalid code');
        }

        if (now()->greaterThan($verificationCode->expires_at)) {
            throw new HttpException(Response::HTTP_BAD_REQUEST, 'Code expired');
        }

        return $verificationCode;
    }

    public function generateUniqueToken()
    {
        do {
            $token = $this->generateToken();
        } while ($this->model()::where('token', $token)->exists());

        return $token;
    }

    private function generateToken()
    {

        return hash_hmac(
            'sha256',
            uniqid(rand(100000000, 100000000000000), true),
            substr(md5(mt_rand()), 500000000, 700000000000)
        );
    }

    private function generateCode()
    {
        return mt_rand(123400, 999999);
    }

    public function checkToken(string $token): VerificationCode
    {
        $verificationCode = $this->findOrFailByToken($token);

        if (!is_null($verificationCode->verified_at)) {
            throw new HttpException(Response::HTTP_BAD_REQUEST, 'Already verified');
        }

        if (now()->greaterThan($verificationCode->expires_at)) {
            throw new HttpException(Response::HTTP_BAD_REQUEST, 'Token expired');
        }

        return $verificationCode;
    }
}
