<?php
class Cart extends Controller
{
    public function add(string $idTutorial = "")
    {
        if (!$this->model('Verify_model')->isUserLogin()) {

            header('Location: ' . BASEURL);
            exit;
        }

        if (!$this->model('Verify_model')->isLoginAsStudent()) return $this->model('Verify_model')->goHome();

        $result = $this->model('Cart_model')->addIntoCart($idTutorial);
        Flasher::setFlash($result['icon'], $result['title'], $result['text']);
        header('Location: ' . BASEURL);
        exit;
    }

    public function viewCart()
    {
        if (!$this->model('Verify_model')->isUserLogin()) {

            header('Location: ' . BASEURL);
            exit;
        }

        if (!$this->model('Verify_model')->isLoginAsStudent()) return $this->model('Verify_model')->goHome();

        $data['style'] = BASEURL . '/css/tutorial-identifier-style.css';
        $data['style-tutorial'] = BASEURL . '/css/tutorial-style.css';
        $data['script-modal-detail-tutorial'] = BASEURL . '/js/script-modal-detail-tutorial.js';
        $data['script-axios'] = 'https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js';
        $data['script-load-more'] = BASEURL . '/js/script-load-more.js';
        $data['cart'] = $this->model('Cart_model')->getCartDataBy();
        $data['total-cart'] = $this->model('Cart_model')->getTotalTutorialsInCart();
        if (empty($data['cart'])) return $this->model('Verify_model')->goHome();

        $twig = $this->view();
        echo $twig->render(
            '/templates/header.html.twig',
            [
                'style' => $data['style'],
                'style_tutorial' => $data['style-tutorial'],
                'BASEURL' => BASEURL,
                'login_teacher' => $_SESSION['login_teacher'] ?? false,
                'login_student' => $_SESSION['login_student'] ?? false,
                'username_teacher' => $_SESSION['username_teacher'] ?? '',
                'username_student' => $_SESSION['username_student'] ?? ''
            ]
        );

        echo $twig->render(
            '/tutorial/bases/tutorial-identifier.html.twig',
            ['tutorial_identifier' => 'Cart']
        );

        echo $twig->render(
            '/tutorial/student/cart/tutorial.html.twig',
            [
                'tutorials' => $data['cart'],
                'total_tutorials' => $data['total-cart'],
                'flash' => Flasher::flash() ?? '', // utk cancel
                'BASEURL' => BASEURL

            ]
        );

        echo $twig->render(
            '/templates/footer.html.twig',
            [
                'script_axios' => $data['script-axios'],
                'script_modal_detail_tutorial' => $data['script-modal-detail-tutorial'],
                'script_load_more' => $data['script-load-more'],
                'BASEURL' => BASEURL
            ]
        );
    }
}
