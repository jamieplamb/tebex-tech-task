<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\UnexpectedLookupResponseException;
use App\Exceptions\UnsupportedLookupTypeException;
use App\Http\Requests\LookupRequest;
use App\Http\Resources\LookupResource;
use App\Services\PlatformLookupFactory;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class LookupController
 *
 * @package App\Http\Controllers
 */
class LookupController extends Controller
{
    protected PlatformLookupFactory $platformLookupFactory;

    /**
     * @param PlatformLookupFactory $platformLookupFactory
     */
    public function __construct(PlatformLookupFactory $platformLookupFactory)
    {
        $this->platformLookupFactory = $platformLookupFactory;
    }

    /**
     * @param LookupRequest $request
     * @return JsonResponse|LookupResource
     * @throws Exception
     */
    public function lookup(LookupRequest $request): JsonResponse|LookupResource
    {
        try {
            $lookupService = $this->platformLookupFactory->create(
                $request->get('type'),
            );

            return new LookupResource(
                ($request->has('username'))
                    ? $lookupService->lookupByUsername($request->get('username'))
                    : $lookupService->lookupById($request->get('id'))
            );
        } catch (UnsupportedLookupTypeException) {
            return response()->json([
                'error' => 'Steam only supports IDs'
            ], Response::HTTP_BAD_REQUEST);
        } catch (UnexpectedLookupResponseException $e) {
            return response()->json([
                'error' => 'Lookup Failed: ' . $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
