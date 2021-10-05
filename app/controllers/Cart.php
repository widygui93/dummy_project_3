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

    public function view()
    {
        if (!$this->model('Verify_model')->isUserLogin()) {

            header('Location: ' . BASEURL);
            exit;
        }

        if (!$this->model('Verify_model')->isLoginAsStudent()) return $this->model('Verify_model')->goHome();

        $data['cart'] = $this->model('Cart_model')->getCartDataBy();
        if (empty($data['cart'])) return $this->model('Verify_model')->goHome();


        $data['style'] = BASEURL . '/css/cart-style.css';
        $data['style-tutorial'] = BASEURL . '/css/tutorial-style.css';
        // $data['script'] = BASEURL . '/js/script-home.js';
        $data['script-modal-detail-tutorial'] = BASEURL . '/js/script-modal-detail-tutorial.js';
        $data['script-axios'] = 'https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js';
        $data['script-load-more'] = BASEURL . '/js/script-load-more.js';

        // $data['style'] = BASEURL . '/css/cart-style.css';
        // $data['script'] = BASEURL . '/js/script-profile.js';
        $twig = $this->view();
        echo $twig->render(
            '/templates/header.html.twig',
            [
                'style' => $data['style'],
                'BASEURL' => BASEURL,
                'login_teacher' => $_SESSION['login_teacher'] ?? false,
                'login_student' => $_SESSION['login_student'] ?? false,
                'username_teacher' => $_SESSION['username_teacher'] ?? '',
                'username_student' => $_SESSION['username_student'] ?? ''
            ]
        );

        echo $twig->render(
            '/tutorial/student/cart/tutorial.html.twig',
            [
                'cart' => $data['cart'],
                'flash' => Flasher::flash() ?? '', // utk cancel
                'BASEURL' => BASEURL

            ]
        );

        echo $twig->render('/templates/footer.html.twig', ['BASEURL' => BASEURL]);
    }
}
