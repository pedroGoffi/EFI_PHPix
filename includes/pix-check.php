<?php
require_once __DIR__ . "/pix-api.php";

use Efi\Exception\EfiException;
use EfiPix;

/**
 * Classe Singleton para verificação de pagamentos via API Pix da EfiPay.
 */
class EfiPixCheck {
    /**
     * Instância única da classe (Singleton).
     *
     * @var EfiPixCheck|null
     */
    private static ?EfiPixCheck $instance = null;

    /**
     * Instância da API Pix encapsulada pela classe EfiPix.
     *
     * @var EfiPix
     */
    private EfiPix $pixApi;

    /**
     * Construtor privado para evitar múltiplas instâncias.
     * Carrega as configurações e inicializa a API Pix.
     */
    private function __construct() {        
        $this->pixApi = EfiPix::getInstance();
    }

    /**
     * Retorna a instância única da classe EfiPixCheck.
     *
     * @return EfiPixCheck
     */
    public static function getInstance(): EfiPixCheck {
        if (self::$instance === null) {
            self::$instance = new EfiPixCheck();
        }
        return self::$instance;
    }

    /**
     * Verifica o status de um pagamento Pix com base no TXID.
     *
     * @param string $txid Identificador único da transação Pix.
     * 
     * @return array|false Retorna os detalhes da transação se bem-sucedida, ou false em caso de falha.
     */
    public function checkPixPayment(string $txid): array|false {
        try {
            $response = $this->pixApi->getApi()->checkPixPayment(txid: $txid);
            return is_array($response) ? $response : false;
        } catch (EfiException) {
            return false;
        }
    }

    public static function check(string $txid): array|false {
        return self::getInstance()->checkPixPayment($txid);
    }
}