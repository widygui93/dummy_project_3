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

        return R::count(
            'cart', 
            ' id_tutorial = :id AND username_student = :username AND is_checkout = :isCheckout AND is_cancel = :isCancel', 
            [':id' => $idTutorial, ':username' => $_SESSION["username_student"], ':isCheckout' => 'N',':isCancel' => 'N']
        ) > 0  ? true : false;
    }

    public function getTotalTutorialsInCart(): int
    {
        return R::count(
            'cart', ' username_student = :username AND is_checkout = :isCheckout AND is_cancel = :isCancel',
            [
                ':username' => $_SESSION["username_student"],
                ':isCheckout' => 'N',
                ':isCancel' => 'N'
            ]
        );
    }

    public function getCartDataBy()
    {

        $numOfTutorials = $this->getTotalTutorialsInCart();
        if ($numOfTutorials > 0) {
            $query = "
                SELECT 
                    COUNT(id_like_tutorial) AS total_like,
                    title,
                    id,
                    img_cover,
                    created_by,
                    prize,
                    created_date,
                    tutorial_date
                FROM (
                    SELECT tutorial.title,
                            tutorial.id,
                            tutorial.img_cover,
                            tutorial.created_by,
                            to_char(tutorial.prize, '999,999,999') AS prize,
                            to_char(tutorial.created_date, 'Month DD,YYYY') AS created_date,
                            tutorial.created_date AS tutorial_date,
                            liked_tutorial.id as id_like_tutorial
                    FROM tutorial
                    FULL OUTER JOIN liked_tutorial ON tutorial.id=liked_tutorial.tutorial_id
                    FULL OUTER JOIN cart ON tutorial.id::text = cart.id_tutorial::text
                    WHERE tutorial.is_revoke = 'N'
                    AND cart.username_student = :username AND cart.is_checkout = 'N'
                    AND cart.is_cancel = 'N'
                ) AS tbl_tutorial
                GROUP BY title,
                id,
                img_cover,
                created_by,
                prize,
                created_date,
                tutorial_date
                ORDER BY tutorial_date DESC
                LIMIT " . TUTORIALS_PER_PAGE . "
            ";

            $dataCart = R::getAll($query, [':username' =>  $_SESSION["username_student"]]);

            $dataCart = $this->shortenTitle($dataCart);

            return $dataCart;
        } else {
            $dataCart = array();
            return $dataCart;
        }
    }

    public function cancelTutorialInCart(string $idTutorial)
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
        } else {

            $id = R::getAll(
                "SELECT ID FROM cart WHERE username_student = :usernameStudent AND id_tutorial = :idTutorial AND is_cancel = :isCancel",
                [ ':usernameStudent' =>  $_SESSION["username_student"], ':idTutorial' => $idTutorial, ':isCancel' => 'N' ]
            );

            $cancelTutorial = R::load('cart', $id[0]["id"]);
            $cancelTutorial->is_cancel = 'Y'; 

            try {
                if (R::store($cancelTutorial)) {
                    return [
                        'icon' => 'success',
                        'title' => 'Success',
                        'text' => 'Cancel tutorial successfully'
                    ];
                } else {
                    throw new Exception();
                }
            } catch (Exception $e) {
                return [
                    'icon' => 'error',
                    'title' => 'Failed',
                    'text' => 'Cancel tutorial failed'
                ];
            }
        }

    }
}
