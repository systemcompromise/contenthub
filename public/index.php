<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/cors.php';
require_once __DIR__ . '/../src/Content.php';

applyCorsHeaders();

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

header('Content-Type: application/json; charset=utf-8');

function validateInput(?array $data): array {
    $errors = [];
    if (empty($data['title']))               $errors[] = 'Judul wajib diisi';
    if (strlen($data['title'] ?? '') > 255)  $errors[] = 'Judul maksimal 255 karakter';
    if (empty($data['body']))                $errors[] = 'Isi konten wajib diisi';
    if (empty($data['author']))              $errors[] = 'Penulis wajib diisi';
    if (strlen($data['author'] ?? '') > 100) $errors[] = 'Nama penulis maksimal 100 karakter';
    return $errors;
}

$action = $_GET['action'] ?? '';
$method = $_SERVER['REQUEST_METHOD'];

$methodOverride = $_GET['_method'] ?? '';
if ($methodOverride) {
    $method = strtoupper($methodOverride);
}

$content = new Content();

try {
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    switch ($method) {
        case 'GET':
            if ($id > 0) {
                $item = $content->getById($id);
                if (!$item) {
                    http_response_code(404);
                    echo json_encode(['error' => 'Konten tidak ditemukan']);
                    exit;
                }
                $content->incrementViews($id);
                echo json_encode(['success' => true, 'data' => $item]);
            } elseif ($action === 'stats') {
                echo json_encode(['success' => true, 'data' => $content->getStats()]);
            } else {
                $status = $_GET['status'] ?? '';
                $search = $_GET['search'] ?? '';
                echo json_encode(['success' => true, 'data' => $content->getAll($status, $search)]);
            }
            break;

        case 'POST':
            $input  = json_decode(file_get_contents('php://input'), true) ?? $_POST;
            $errors = validateInput($input);
            if ($errors) {
                http_response_code(422);
                echo json_encode(['error' => implode(', ', $errors)]);
                exit;
            }
            $item = $content->create($input);
            http_response_code(201);
            echo json_encode([
                'success' => true,
                'data'    => $item,
                'message' => 'Konten berhasil dibuat',
            ]);
            break;

        case 'PUT':
            if (!$id) {
                http_response_code(400);
                echo json_encode(['error' => 'ID diperlukan']);
                exit;
            }
            $input  = json_decode(file_get_contents('php://input'), true);
            $errors = validateInput($input);
            if ($errors) {
                http_response_code(422);
                echo json_encode(['error' => implode(', ', $errors)]);
                exit;
            }
            $item = $content->update($id, $input);
            echo json_encode([
                'success' => true,
                'data'    => $item,
                'message' => 'Konten berhasil diperbarui',
            ]);
            break;

        case 'DELETE':
            if (!$id) {
                http_response_code(400);
                echo json_encode(['error' => 'ID diperlukan']);
                exit;
            }
            $content->delete($id);
            echo json_encode(['success' => true, 'message' => 'Konten berhasil dihapus']);
            break;

        default:
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
    }
} catch (Exception $e) {
    error_log('[API Error] ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Terjadi kesalahan pada server. Silakan coba lagi.']);
}