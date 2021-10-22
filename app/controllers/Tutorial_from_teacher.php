<?php
class Tutorial_from_teacher extends Controller
{
    public function viewTutorial(string $username_teacher = "")
    {
        $data['style'] = BASEURL . '/css/tutorial-identifier-style.css';
        $data['style-tutorial'] = BASEURL . '/css/tutorial-style.css';
        $data['script-modal-detail-tutorial'] = BASEURL . '/js/script-modal-detail-tutorial.js';
        $data['script-axios'] = 'https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js';
        $data['script-load-more'] = BASEURL . '/js/script-load-more.js';

        $username_teacher = htmlspecialchars($username_teacher);

        $data['tutorials'] = $this->model('Tutorial_from_teacher_model')->getTutorialsBy($username_teacher);
        $data['total-tutorials'] = $this->model('Tutorial_from_teacher_model')->getTotalTutorialsBy($username_teacher);

        $data['total-carts'] = 0;
		if (isset($_SESSION['login_student'])) {

			$data['total-carts'] = $this->model('Cart_model')->getTotalTutorialsInCart();
		}

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
                'username_student' => $_SESSION['username_student'] ?? '',
                'total_carts' => $data['total-carts']
            ]
        );

        echo $twig->render(
            '/tutorial/bases/tutorial-identifier.html.twig',
            ['tutorial_identifier' => "Tutorial from $username_teacher"]
        );

        if (isset($_SESSION['login_teacher'])) {

            echo empty($data['tutorials'])
                ? $twig->render('/tutorial/no-tutorial.html.twig') :
                $twig->render(
                    '/tutorial/bases/tutorial-complete.html.twig',
                    [
                        'tutorials' => $data['tutorials'],
                        'total_tutorials' => $data['total-tutorials'],
                        'BASEURL' => BASEURL
                    ]
                );
        } else {
            // nanti di sini muncul view kumpulan tutorial yg ada tombol purchase aja
            // klu tombol purchase di klik nanti minta login dulu sebagai student
            // echo "ini view kosong";
            // jika setelah di lakukan fuzzy search tapi semua hasil nya dalam is_revoke = Y
            // maka tampilkan no tutorial view
            echo empty($data['tutorials'])
                ? $twig->render('/tutorial/no-tutorial.html.twig') :
                $twig->render(
                    '/tutorial/main-tutorial.html.twig',
                    [
                        'tutorials' => $data['tutorials'],
                        'total_tutorials' => $data['total-tutorials'],
                        'BASEURL' => BASEURL
                    ]
                );
        }

        echo $twig->render(
            '/templates/footer.html.twig',
            [
                'script_axios' => $data['script-axios'],
                'script_modal_detail_tutorial' => $data['script-modal-detail-tutorial'],
                'script_load_more' => $data['script-load-more'],
                'BASEURL' => BASEURL,
                'flash' => Flasher::flash() ?? ''
            ]
        );
    }
}
