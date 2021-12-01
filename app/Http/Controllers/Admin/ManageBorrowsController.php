<?php

namespace App\Http\Controllers\Admin;

use App\Models\Borrow;
use App\Models\Status;
use App\Models\BorrowLog;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\MyService\BookService;
use App\Http\MyService\ResponseService;
use App\Http\Resources\BorrowerResource;
use Illuminate\Http\Client\Events\ResponseReceived;
use Symfony\Component\HttpFoundation\Response;

class ManageBorrowsController extends Controller
{

    private function index($status)
    {
        $dataBorrow = Borrow::with(['book', 'user'])->where('latest_status', $status)->get();
        return ResponseService::wrapStatus(
            Response::HTTP_OK,
            true,
            ['borrows' => BorrowerResource::collection($dataBorrow)]
        );
    }

    public function requestIndex()
    {
        return $this->index(Status::STATUS_REQUEST);
    }

    public function borrowedIndex()
    {
        return $this->index(Status::STATUS_BORROWED);
    }

    public function approvedIndex()
    {
        return $this->index(Status::STATUS_APPROVE);
    }

    public function returnedIndex()
    {
        return $this->index(Status::STATUS_RETURNED);
    }

    public function approving($borrow_id)
    {
        $borrow = $this->findBorrow($borrow_id);
        $changeStatus = $this->changeStatus($borrow, Status::STATUS_APPROVE);
        $httpCode = ($changeStatus) ? Response::HTTP_OK : Response::HTTP_UNPROCESSABLE_ENTITY;
        $message = ($changeStatus) ? "Succes Approving" : "Failed Approving";

        return ResponseService::wrapStatus(
            $httpCode,
            $changeStatus,
            null,
            $message
        );
    }

    public function borrowed($borrow_id)
    {
        $borrow = $this->findBorrow($borrow_id);
        $changeStatus = $this->changeStatus($borrow, Status::STATUS_BORROWED);
        $httpCode = ($changeStatus) ? Response::HTTP_OK : Response::HTTP_UNPROCESSABLE_ENTITY;
        $message = ($changeStatus) ? "Success Borrowed" : "Failed Borrow";

        return ResponseService::wrapStatus(
            $httpCode,
            $changeStatus,
            null,
            $message
        );
    }

    public function returned($borrow_id)
    {
        $borrow = $this->findBorrow($borrow_id);
        $changeStatus = $this->changeStatus($borrow, Status::STATUS_RETURNED);
        BookService::changeStock($borrow->book_id, 'increase');
        $httpCode = ($changeStatus) ? Response::HTTP_OK : Response::HTTP_UNPROCESSABLE_ENTITY;
        $message = ($changeStatus) ? "Succes Returned" : "Failed Return";

        return ResponseService::wrapStatus(
            $httpCode,
            $changeStatus,
            null,
            $message
        );
    }

    private function changeStatus($borrow, $status)
    {
        DB::beginTransaction();
        try {
            $borrow->update(['latest_status' => $status]);
            $borrow->borrowLogs()->create(['status' => $status]);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    public function findBorrow($borrow_id)
    {
        $borrow = Borrow::find($borrow_id);
        if(!$borrow) {
            return ResponseService::notFoundStatus();
        }
        return $borrow;
    }
}