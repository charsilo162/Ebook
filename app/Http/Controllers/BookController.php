<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{
        public function show(Request $request, $uuid, ApiService $api)
        {
            try {
                $response = $api->get("books/{$uuid}");
            } catch (\Throwable $e) {
                logger()->error('BOOK API ERROR', [
                    'uuid' => $uuid,
                    'error' => $e->getMessage(),
                ]);

                return $this->friendlyNotFound();
            }

            if (!isset($response['data'])) {
                logger()->warning('BOOK NOT FOUND', [
                    'uuid' => $uuid,
                    'response' => $response,
                ]);

                return $this->friendlyNotFound();
            }

            $book = $response['data'];

            $type = $request->query('type', $book['default_type'] ?? 'physical');
              // dd( $book);
            $data = [
                'id' => $uuid,
                'authorName' => $book['author'] ?? $book['author_name'],
                'book' => $book,
            ];

            return $type === 'digital'
                ? view('books.digital-show', $data)
                : view('books.physical-show', $data);
        }


        protected function friendlyNotFound()
        {
            return response()
                ->view('errors.book-not-found', [], 404);
        }

}

