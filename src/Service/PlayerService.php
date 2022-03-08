<?php

namespace App\Service;

use App\Form\PlayerType;

use DateTime;
use App\Entity\Player;
use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Finder\Finder;
use LogicException;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use App\Event\PlayerEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class PlayerService implements PlayerServiceInterface
{
    private $playerRepository;
    private $em;
    private $formFactory;
    private $validator;
    private $dispatcher;

    public function __construct(
        EntityManagerInterface $em,
        PlayerRepository $playerRepository,
        FormFactoryInterface $formFactory,
        ValidatorInterface $validator,
        EventDispatcherInterface $dispatcher)
    {
        $this->playerRepository = $playerRepository;
        $this->em = $em;
        $this->formFactory = $formFactory;
        $this->validator = $validator;
        $this->dispatcher = $dispatcher;
    }
    /**
     * {@inheritdoc}
     */
    public function create(string $data)
    {
        //Use with {"firstname":"Eldalótë","lastname":"Fleur","email":"elfe@trap.com","mirian":"500"}
        $player = new Player();
        $player
        ->setIdentifier(hash('sha1', uniqid()))
        ->setCreation(new \DateTime())
        ->setModification(new \DateTime())
    ;
        $this->submit($player, PlayerType::class, $data);
        $this->isEntityFilled($player);

        $this->em->persist($player);
        $this->em->flush();
        return $player;
    }
    public function isEntityFilled(Player $player)
    {
        $errors = $this->validator->validate($player);
        if (count($errors) > 0) {
            throw new UnprocessableEntityHttpException((string) $errors . 'Missing data for Entity -> ' . $this->serializeJson($player));
        }
    }
    /**
    * {@inheritdoc}
    */
    public function submit(Player $player, $formName, $data)
    {
        $dataArray = is_array($data) ? $data : json_decode($data, true);

        //Bad array
        if (null !== $data && !is_array($dataArray)) {
            throw new UnprocessableEntityHttpException('Submitted data is not an array -> ' . $data);
        }

        //Submits form
        $form = $this->formFactory->create($formName, $player, ['csrf_protection' => false]);
        $form->submit($dataArray, false);//With false, only submitted fields are validated

        //Gets errors
        $errors = $form->getErrors();
        foreach ($errors as $error) {
            throw new LogicException('Error ' . get_class($error->getCause()) . ' --> ' . $error->getMessageTemplate() . ' ' . json_encode($error->getMessageParameters()));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getAll()
    {
    }

    /**
    * {@inheritdoc}
    */
    public function modify(Player $player, string $data)
    {
        $this->submit($player, PlayerType::class, $data);
        $event = new PlayerEvent($player);
        $this->dispatcher->dispatch($event, PlayerEvent::PLAYER_MODIFIED);
        $this->isEntityFilled($player);
        $player
        ->setModification(new \DateTime())
        ;
        $this->em->persist($player);
        $this->em->flush();
        return $player;
    }

    /**
    * {@inheritdoc}
    */
    public function delete(Player $player)
    {
        $this->em->remove($player);
        $this->em->flush();
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function serializeJson($data)
    {
        $encoders = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($data) {
                return $data->getIdentifier();
            },
        ];
        $normalizers = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);
        $serializer = new Serializer([new DateTimeNormalizer(), $normalizers], [$encoders]);
        return $serializer->serialize($data, 'json');
    }
}
