<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Trick;
use App\Entity\TrickPicture;
use App\Entity\TrickVideo;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {

        $commentText = [
            'The snowboarding trick I recently witnessed was simply breathtaking. The rider executed a "backside 540," a
        maneuver that demands great skill and impeccable timing. The moment when they launched off the ramp and
        began their rotation was magical.',

            'In the air, they seemed to hang there for an eternity, completing a full 540-degree spin. Their board followed a
        perfect trajectory, and they managed to land smoothly, in harmony with the slope of the slope. The audacity of this
        trick, combined with the grace of its execution, truly captivated the entire audience.',

            'It was a true example of the marriage between technique and art in snowboarding, and it reminded everyone why this
        sport is so awe-inspiring to watch. This rider certainly pushed the boundaries of what is possible on a snowboard, and
        their talent deserves genuine recognition.'
        ];

        $snowText = [
            'Snowboarding is a sport filled with impressive and creative tricks. Among the most iconic are
        the jumps. The "ollie" serves as the foundation for many tricks, where the rider pops the board by pressing on
        the tail. The "360" involves a full rotation in the air, while the "backflip" is a daring backward somersault
        that demands both courage and technique. "Grinding" is sliding along metal rails or ramps, and the "method air"
        is an elegant aerial grab.',

            'Each rider develops their unique style, combining these tricks to create one-of-a-kind
        sequences, offering an incredible show on the snow-covered slopes. Snowboarding is more than just a winter
        sport; it\'s an artistic form of expression that constantly pushes the boundaries of creativity.'
        ];

        $videoUrl = [
            'https://www.youtube.com/watch?v=hm68sxK0We4',
            'https://www.youtube.com/watch?v=aNq36NzNAFU',
            'https://www.youtube.com/watch?v=t705_V-RDcQ',
            'https://www.youtube.com/watch?v=kmUUrAKRioE',
            'https://www.youtube.com/watch?v=UGf2P6O-grk',
            'https://www.youtube.com/watch?v=V9xuy-rVj9w',
            'https://www.youtube.com/watch?v=FMHiSF0rHF8',
            'https://www.youtube.com/watch?v=zeDUIgJ6yjM',
            'https://www.youtube.com/watch?v=5CvLYq54M7Y',
            'https://www.youtube.com/watch?v=N9TQlHsLQ2E',
            'https://www.dailymotion.com/video/xxxu60',
            'https://www.dailymotion.com/video/x8amo4p',
            'https://www.dailymotion.com/video/xefk8l',
            'https://www.dailymotion.com/video/x1ey4wl',
            'https://www.dailymotion.com/video/x2fudcm',
            'https://www.dailymotion.com/video/xxunll'
        ];

        $user = new User();
        $user
            ->setUsername('laurent')
            ->setEmail('laurent@gmail.com')
            ->setMedia('default.png')
            ->setPassword('$2y$13$pGH91S7PI0dAgdwundiFS.PcFjn06Sy9vrkJvcCg.y7cI1IjqN/K2')
            ->setActive(true)
            ->setExpirationDate(strtotime('now'));
        $manager->persist($user);

        $categoryGrabs = new Category();
        $categoryGrabs->setLabel('grabs');
        $manager->persist($categoryGrabs);

        $grabsName = ['mute', 'sad', 'indy', 'stalefish', 'tail grab', 'nose grab', 'japan', 'seat belt', 'truck driver'];
        $grabsSlug = ['mute', 'sad', 'indy', 'stalefish', 'tail-grab', 'nose-grab', 'japan', 'seat-belt', 'truck-driver'];
        $grabsDescription = [
            'Frontside edge grab between the two feet with the front hand.',
            'Backside edge grab between the two feet with the front hand.',
            'Frontside edge grab between the two feet with the rear hand.',
            'Backside edge grab between the two feet with the rear hand.',
            'Grabbing the rear of the board with the rear hand.',
            'Grabbing the front of the board with the front hand.',
            'Grabbing the front of the board with the front hand, on the frontside edge.',
            'Grabbing the frontside edge at the back with the front hand.',
            'Grabbing both the front and back edges with each hand (like holding a car steering wheel).'
        ];

        for ($i = 0; $i < count($grabsName); $i++) {
            $trickGrabs = new Trick();
            $trickGrabs
                ->setName($grabsName[$i])
                ->setSlug($grabsSlug[$i])
                ->setDescription($grabsDescription[$i] . $snowText[rand(0, 1)])
                ->setCategory($categoryGrabs);
            $manager->persist($trickGrabs);

            for ($pic = 0; $pic < 5; $pic++) {
                $rand = rand(0, 23);
                $picture = new TrickPicture();
                if ($pic === 0){
                    $picture->setFirstPicture(true);
                }
                $picture
                    ->setFileName('trick-' . $rand . '.jpg')
                    ->setAlt('trick-' . $rand)
                    ->setTrick($trickGrabs);
                $manager->persist($picture);
            }

            for ($vid = 0; $vid < 5; $vid++) {
                $video = new TrickVideo();
                $video
                    ->setUrl($videoUrl[rand(0, 15)])
                    ->setTrick($trickGrabs);
                $manager->persist($video);
            }

            for ($com = 0; $com < 15; $com++) {
                $comment = new Comment();
                $comment
                    ->setContent($commentText[rand(0, 2)])
                    ->setTrick($trickGrabs)
                    ->setUser($user);
                $manager->persist($comment);
            }
        }

        $categoryRotations = new Category();
        $categoryRotations->setLabel('rotations');
        $manager->persist($categoryRotations);

        $rotationsName = ['90', '180', '270', '360', '450', '540', '630', '810', '900', '1080'];
        $rotationDescription = [
            'A simple quarter turn.',
            'Refers to a half-turn, which is 180 degrees of rotation.',
            'Three-quarters of a turn.',
            'Three sixes for a complete turn.',
            'One and a quarter turns.',
            'Five-quarters for a turn and a half.',
            'One and three-quarters turns.',
            'Two and a quarter turns.',
            'Two and a half turns.',
            'Big foot for three turns.'
        ];

        for ($i = 0; $i < count($rotationsName); $i++) {
            $trickRotations = new Trick();
            $trickRotations
                ->setName($rotationsName[$i])
                ->setSlug($rotationsName[$i])
                ->setDescription($rotationDescription[$i] . $snowText[rand(0, 1)])
                ->setCategory($categoryRotations);
            $manager->persist($trickRotations);

            for ($pic = 0; $pic < 5; $pic++) {
                $rand = rand(0, 23);
                $picture = new TrickPicture();
                if ($pic === 0){
                    $picture->setFirstPicture(true);
                }
                $picture
                    ->setFileName('trick-' . $rand . '.jpg')
                    ->setAlt('trick-' . $rand)
                    ->setTrick($trickRotations);
                $manager->persist($picture);
            }

            for ($vid = 0; $vid < 5; $vid++) {
                $video = new TrickVideo();
                $video
                    ->setUrl($videoUrl[rand(0, 15)])
                    ->setTrick($trickRotations);
                $manager->persist($video);
            }

            for ($com = 0; $com < 15; $com++) {
                $comment = new Comment();
                $comment
                    ->setContent($commentText[rand(0, 2)])
                    ->setTrick($trickRotations)
                    ->setUser($user);
                $manager->persist($comment);
            }
        }

        $categoryFlips = new Category();
        $categoryFlips->setLabel('flips');
        $manager->persist($categoryFlips);

        $flipsName = ['mac twist', 'hakon flip'];
        $flipsSlug = ['mac-twist', 'hakon-flip'];

        for ($i = 0; $i < count($flipsName); $i++) {
            $trickFlips = new Trick();
            $trickFlips
                ->setName($flipsName[$i])
                ->setSlug($flipsSlug[$i])
                ->setDescription($snowText[rand(0, 1)])
                ->setCategory($categoryFlips);
            $manager->persist($trickFlips);

            for ($pic = 0; $pic < 5; $pic++) {
                $rand = rand(0, 23);
                $picture = new TrickPicture();
                if ($pic === 0){
                    $picture->setFirstPicture(true);
                }
                $picture
                    ->setFileName('trick-' . $rand . '.jpg')
                    ->setAlt('trick-' . $rand)
                    ->setTrick($trickFlips);
                $manager->persist($picture);
            }

            for ($vid = 0; $vid < 5; $vid++) {
                $video = new TrickVideo();
                $video
                    ->setUrl($videoUrl[rand(0, 15)])
                    ->setTrick($trickFlips);
                $manager->persist($video);
            }

            for ($com = 0; $com < 15; $com++) {
                $comment = new Comment();
                $comment
                    ->setContent($commentText[rand(0, 2)])
                    ->setTrick($trickFlips)
                    ->setUser($user);
                $manager->persist($comment);
            }
        }

        $categoryOffAxis = new Category();
        $categoryOffAxis->setLabel('off-axis rotations');
        $manager->persist($categoryOffAxis);

        $offAxisName = ['corkscrew', 'rodeo', 'misty'];

        for ($i = 0; $i < count($offAxisName); $i++) {
            $trickOffAxis = new Trick();
            $trickOffAxis
                ->setName($offAxisName[$i])
                ->setSlug($offAxisName[$i])
                ->setDescription($snowText[rand(0, 1)])
                ->setCategory($categoryOffAxis);
            $manager->persist($trickOffAxis);

            for ($pic = 0; $pic < 5; $pic++) {
                $rand = rand(0, 23);
                $picture = new TrickPicture();
                if ($pic === 0){
                    $picture->setFirstPicture(true);
                }
                $picture
                    ->setFileName('trick-' . $rand . '.jpg')
                    ->setAlt('trick-' . $rand)
                    ->setTrick($trickOffAxis);
                $manager->persist($picture);
            }

            for ($vid = 0; $vid < 5; $vid++) {
                $video = new TrickVideo();
                $video
                    ->setUrl($videoUrl[rand(0, 15)])
                    ->setTrick($trickOffAxis);
                $manager->persist($video);
            }

            for ($com = 0; $com < 15; $com++) {
                $comment = new Comment();
                $comment
                    ->setContent($commentText[rand(0, 2)])
                    ->setTrick($trickOffAxis)
                    ->setUser($user);
                $manager->persist($comment);
            }
        }

        $categorySlides = new Category();
        $categorySlides->setLabel('slides');
        $manager->persist($categorySlides);

        $slidesName = ['nose slide', 'tail slide'];
        $slidesSlug = ['nose-slide', 'tail-slide'];

        for ($i = 0; $i < count($slidesName); $i++) {
            $trickSlides = new Trick();
            $trickSlides
                ->setName($slidesName[$i])
                ->setSlug($slidesSlug[$i])
                ->setDescription($snowText[rand(0, 1)])
                ->setCategory($categorySlides);
            $manager->persist($trickSlides);

            for ($pic = 0; $pic < 5; $pic++) {
                $rand = rand(0, 23);
                $picture = new TrickPicture();
                if ($pic === 0){
                    $picture->setFirstPicture(true);
                }
                $picture
                    ->setFileName('trick-' . $rand . '.jpg')
                    ->setAlt('trick-' . $rand)
                    ->setTrick($trickSlides);
                $manager->persist($picture);
            }

            for ($vid = 0; $vid < 5; $vid++) {
                $video = new TrickVideo();
                $video
                    ->setUrl($videoUrl[rand(0, 15)])
                    ->setTrick($trickSlides);
                $manager->persist($video);
            }

            for ($com = 0; $com < 15; $com++) {
                $comment = new Comment();
                $comment
                    ->setContent($commentText[rand(0, 2)])
                    ->setTrick($trickSlides)
                    ->setUser($user);
                $manager->persist($comment);
            }
        }

        $categoryOneFoot = new Category();
        $categoryOneFoot->setLabel('one foot tricks');
        $manager->persist($categoryOneFoot);

        $categoryOldSchool = new Category();
        $categoryOldSchool->setLabel('old school');
        $manager->persist($categoryOldSchool);

        $oldSchoolName = ['backside air', 'method air'];
        $oldSchoolSlug = ['backside-air', 'method-air'];

        for ($i = 0; $i < count($oldSchoolName); $i++) {
            $trickOldSchool = new Trick();
            $trickOldSchool
                ->setName($oldSchoolName[$i])
                ->setSlug($oldSchoolSlug[$i])
                ->setDescription($snowText[rand(0, 1)])
                ->setCategory($categoryOldSchool);
            $manager->persist($trickOldSchool);

            for ($pic = 0; $pic < 5; $pic++) {
                $rand = rand(0, 23);
                $picture = new TrickPicture();
                if ($pic === 0){
                    $picture->setFirstPicture(true);
                }
                $picture
                    ->setFileName('trick-' . $rand . '.jpg')
                    ->setAlt('trick-' . $rand)
                    ->setTrick($trickOldSchool);
                $manager->persist($picture);
            }


            for ($vid = 0; $vid < 5; $vid++) {
                $video = new TrickVideo();
                $video
                    ->setUrl($videoUrl[rand(0, 15)])
                    ->setTrick($trickOldSchool);
                $manager->persist($video);
            }


            for ($com = 0; $com < 15; $com++) {
                $comment = new Comment();
                $comment
                    ->setContent($commentText[rand(0, 2)])
                    ->setTrick($trickOldSchool)
                    ->setUser($user);
                $manager->persist($comment);
            }
        }
        $manager->flush();

    }


}