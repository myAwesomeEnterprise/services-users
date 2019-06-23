<?php

namespace App\Auth;

use App\Entities\User;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use \League\OAuth2\Server\ResponseTypes\BearerTokenResponse as TokenResponse;

class BearerTokenResponse extends TokenResponse
{
    /**
     * Add custom fields to your Bearer Token response here, then override
     * AuthorizationServer::getResponseType() to pull in your version of
     * this class rather than the default.
     *
     * @param AccessTokenEntityInterface $accessToken
     *
     * @return array
     */
    protected function getExtraParams(AccessTokenEntityInterface $accessToken)
    {
        $user = User::find($this->accessToken->getUserIdentifier());

        return [
            'user_uuid' => $user->uuid,
        ];
    }
}
