<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Solicitud.php';
require_once __DIR__ . '/../models/Taller.php';

class AdminController
{
    private $solicitudModel;
    private $tallerModel;

    public function __construct()
    {
        $database = new Database();
        $db = $database->connect();
        $this->solicitudModel = new Solicitud($db);
        $this->tallerModel = new Taller($db);
    }

    public function solicitudes()
    {
        if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
            header('Location: index.php?page=login');
            return;
        }
        require __DIR__ . '/../views/admin/solicitudes.php';
    }
    
    public function getSolicitudesJson()
    {
        if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
            echo json_encode([]);
            return;
        }
        $solicitudes = $this->solicitudModel->getPendientes();
        header('Content-Type: application/json');
        echo json_encode($solicitudes);
    }

    public function aprobar()
    {
        if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
            echo json_encode(['success' => false, 'error' => 'No autorizado']);
            return;
        }
        
        $solicitudId = $_POST['id_solicitud'] ?? 0;
        
        try {
            $solicitud = $this->solicitudModel->getSolicitudById($solicitudId);
            if (!$solicitud || $solicitud['estado'] !== 'pendiente') {
                throw new Exception('Solicitud no válida o ya procesada');
            }
            
            $tallerId = $solicitud['taller_id'];
 
            $taller = $this->tallerModel->getById($tallerId);
            if (!$taller || $taller['cupo_disponible'] <= 0) {
                throw new Exception('No hay cupos disponibles para este taller');
            }

            if (!$this->tallerModel->descontarCupo($tallerId)) {
                throw new Exception('Error al descontar cupo');
            }
   
            if (!$this->solicitudModel->aprobar($solicitudId)) {
                $this->tallerModel->sumarCupo($tallerId);
                throw new Exception('Error al actualizar la solicitud');
            }
            
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function rechazar()
    {
        if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
            echo json_encode(['success' => false, 'error' => 'No autorizado']);
            return;
        }
        
        $solicitudId = $_POST['id_solicitud'] ?? 0;
 
        $solicitud = $this->solicitudModel->getSolicitudById($solicitudId);
        if (!$solicitud || $solicitud['estado'] !== 'pendiente') {
            echo json_encode(['success' => false, 'error' => 'Solicitud no válida o ya procesada']);
            return;
        }
        
        if ($this->solicitudModel->rechazar($solicitudId)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Error al rechazar']);
        }
    }
}