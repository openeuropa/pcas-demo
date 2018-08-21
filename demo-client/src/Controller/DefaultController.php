<?php
namespace App\Controller;

use OpenEuropa\pcas\PCas;
use OpenEuropa\pcas\PCasFactory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /** @var \openeuropa\pcas\PCasFactory */
    private $pCasFactory;

  /**
   * Get a PcasFactory instance.
   * @return PCasFactory
   */
    protected function getPcasFactory()
    {
      if (null === $this->pCasFactory) {
        $this->pCasFactory = $this->container->get('pcas.pcas_factory');
      }

      return $this->pCasFactory;
    }

  /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        /** @var \OpenEuropa\pcas\PCas $pCas */
        $pCas = $this->getPcasFactory()->getPCas();

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
          'base_dir'   => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
          'properties' => $pCas->getProperties(),
          'user'       => $this->getUser(),
        ] + $this->defaultVars($pCas, $request));
    }

    public function defaultVars(pCas $pCas, Request $request = null)
    {
        if ($user = $pCas->getAuthenticatedUser()) {
            $name = is_null($user->get('cas:firstName')) ? $user->get('cas:user') : $user->get('cas:firstName') . ' ' . ucfirst(strtolower($user->get('cas:lastName')));

            $welcome = sprintf('Welcome back, %s !', $name);
            $link = [
                'href'  => '/logout',
                'text'  => 'Log out',
                'class' => 'btn btn-danger btn-lg btn-block',
            ];
        } else {
            $welcome = "Welcome, guest !";
            $link = [
                'href'  => '/login',
                'text'  => 'Log in',
                'class' => 'btn btn-success btn-lg btn-block',
            ];
        }

        return [
            'welcome'    => $welcome,
            'link'       => $link,
            'properties' => $pCas->getProperties(),
            'server'     => $request->server,
            'session'    => $pCas->getSession()->all(),
            'auth'       => $pCas->isAuthenticated(),
            'user'       => $pCas->getAuthenticatedUser(),
        ];
    }
}
