<?php
class Cart_model extends Model
{

    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function addIntoCart(string $idTutorial): array
    {
        if (empty($idTutorial)) {
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'ID is mandatory'
            ];
        } elseif ($this->isIDNotUUID($idTutorial)) {
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'ID is invalid data type'
            ];
        } elseif ($this->isIdNotAvailable($idTutorial)) {
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Tutorial is not available'
            ];
        } elseif ($this->isIDRevoked($idTutorial)) {
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Tutorial has been revoked'
            ];
        } elseif ($this->hasTutorialAdded($idTutorial)) {
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Tutorial has been added'
            ];
        } else {
            $createdDate = $this->getDate();

            $cart = R::dispense('cart');
            $cart->username_student = $_SESSION["username_student"];
            $cart->id_tutorial = $idTutorial;
            $cart->created_date = $createdDate;
            $cart->is_checkout = 'N';
            $cart->is_cancel = 'N';

            try {
                if (R::store($cart)) {
                    return [
                        'icon' => 'success',
                        'title' => 'Success',
                        'text' => 'Add tutorial into cart successfully'
                    ];
                } else {
                    throw new Exception();
                }
            } catch (Exception $e) {
                return [
                    'icon' => 'error',
                    'title' => 'Failed',
                    'text' => 'Add tutorial into cart failed'
                ];
            }
        }
    }

    private function hasTutorialAdded(string $idTutorial): bool
    {

        return R::count('cart', ' id_tutorial = :id AND username_student = :username', [':id' => $idTutorial, ':username' => $_SESSION["username_student"]]) > 0  ? true : false;
    }

    public function getTotalTutorialsInCart(): int
    {
        return R::count('cart', ' username_student = :username', [':username' => $_SESSION["username_student"]]);
    }

    public function getCartDataBy()
    {
        $_SESSION["username_student"];
    }
}
