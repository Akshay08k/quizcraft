-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2024 at 07:06 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quizcraft`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(78, 'General Knowledge & Current Affairs', '2024-11-28 13:57:03', '2024-11-28 13:57:03'),
(79, 'Science & Technology', '2024-11-28 13:57:03', '2024-11-28 13:57:03'),
(80, 'Mathematics', '2024-11-28 13:57:03', '2024-11-28 13:57:03'),
(81, 'Arts & Entertainment', '2024-11-28 13:57:03', '2024-11-28 13:57:03'),
(82, 'Literature & Languages', '2024-11-28 13:57:03', '2024-11-28 13:57:03'),
(83, 'Sports & Fitness', '2024-11-28 13:57:03', '2024-11-28 13:57:03'),
(84, 'Business & Economy', '2024-11-28 13:57:03', '2024-11-28 13:57:03'),
(85, 'History & Geography', '2024-11-28 13:57:03', '2024-11-28 13:57:03'),
(86, 'Education & Academics', '2024-11-28 13:57:03', '2024-11-28 13:57:03'),
(87, 'Pop Culture & Media', '2024-11-28 13:57:03', '2024-11-28 13:57:03');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `comment_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`options`)),
  `quiz_id` int(11) NOT NULL,
  `correct_answer` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `question_text`, `options`, `quiz_id`, `correct_answer`) VALUES
(221, 'What is The todays date', '[\"gadg\",\"sdfg\",\"sdfg\",\"dfg\"]', 2, 'B'),
(222, 'what is today name', '[\"dfgq\",\"sdfg\",\"adg\",\"dg\"]', 2, 'A'),
(223, 'Who Is Creater of english', '[\"Victor\",\"Me\",\"You\",\"DOnt Know\"]', 5, 'B'),
(224, 'What is the capital of France?', '[\"Paris\", \"London\", \"Berlin\", \"Rome\"]', 7, 'A'),
(225, 'Which city is the capital of Japan?', '[\"Tokyo\", \"Osaka\", \"Kyoto\", \"Nagoya\"]', 7, 'A'),
(226, 'What is the capital of Australia?', '[\"Sydney\", \"Melbourne\", \"Canberra\", \"Brisbane\"]', 7, 'C'),
(227, 'The capital of Canada is?', '[\"Toronto\", \"Vancouver\", \"Ottawa\", \"Montreal\"]', 7, 'C'),
(228, 'Which city is the capital of Germany?', '[\"Munich\", \"Berlin\", \"Frankfurt\", \"Hamburg\"]', 7, 'B'),
(229, 'The capital of Brazil is?', '[\"São Paulo\", \"Rio de Janeiro\", \"Brasília\", \"Salvador\"]', 7, 'C'),
(230, 'What is the capital of India?', '[\"Mumbai\", \"New Delhi\", \"Bangalore\", \"Kolkata\"]', 7, 'B'),
(231, 'The capital of Russia is?', '[\"Moscow\", \"St. Petersburg\", \"Sochi\", \"Kazan\"]', 7, 'A'),
(232, 'Which city is the capital of China?', '[\"Shanghai\", \"Hong Kong\", \"Beijing\", \"Shenzhen\"]', 7, 'C'),
(233, 'What is the capital of Italy?', '[\"Venice\", \"Milan\", \"Rome\", \"Florence\"]', 7, 'C'),
(234, 'The capital of the United States is?', '[\"New York\", \"Los Angeles\", \"Washington, D.C.\", \"Chicago\"]', 7, 'C'),
(235, 'What is the capital of South Africa?', '[\"Cape Town\", \"Pretoria\", \"Johannesburg\", \"Durban\"]', 7, 'B'),
(236, 'Which city is the capital of Spain?', '[\"Barcelona\", \"Madrid\", \"Seville\", \"Valencia\"]', 7, 'B'),
(237, 'The capital of Argentina is?', '[\"Buenos Aires\", \"Córdoba\", \"Rosario\", \"Mendoza\"]', 7, 'A'),
(238, 'What is the capital of Mexico?', '[\"Guadalajara\", \"Cancún\", \"Mexico City\", \"Monterrey\"]', 7, 'C'),
(239, 'Which city is the capital of Egypt?', '[\"Cairo\", \"Alexandria\", \"Giza\", \"Luxor\"]', 7, 'A'),
(240, 'The capital of Saudi Arabia is?', '[\"Jeddah\", \"Riyadh\", \"Mecca\", \"Dammam\"]', 7, 'B'),
(241, 'What is the capital of Greece?', '[\"Athens\", \"Thessaloniki\", \"Patras\", \"Heraklion\"]', 7, 'A'),
(242, 'Which city is the capital of Portugal?', '[\"Porto\", \"Lisbon\", \"Braga\", \"Coimbra\"]', 7, 'B'),
(243, 'The capital of Thailand is?', '[\"Bangkok\", \"Chiang Mai\", \"Phuket\", \"Pattaya\"]', 7, 'A'),
(244, 'What is the value of x if 2x + 4 = 10?', '[\"2\", \"3\", \"4\", \"5\"]', 8, 'B'),
(245, 'Solve for x: 5x = 25.', '[\"3\", \"4\", \"5\", \"6\"]', 8, 'C'),
(246, 'If x + 3 = 7, what is x?', '[\"2\", \"3\", \"4\", \"5\"]', 8, 'C'),
(247, 'What is the result of 3x = 15?', '[\"4\", \"5\", \"6\", \"7\"]', 8, 'B'),
(248, 'Simplify: 2(x + 3) = 12.', '[\"2\", \"3\", \"4\", \"5\"]', 8, 'C'),
(249, 'If 4x - 8 = 0, find x.', '[\"1\", \"2\", \"3\", \"4\"]', 8, 'B'),
(250, 'Solve: 10x = 100.', '[\"5\", \"10\", \"15\", \"20\"]', 8, 'B'),
(251, 'If x/2 = 4, what is x?', '[\"6\", \"8\", \"10\", \"12\"]', 8, 'B'),
(252, 'What is x in 7x = 49?', '[\"5\", \"6\", \"7\", \"8\"]', 8, 'C'),
(253, 'Solve: x + 5 = 12.', '[\"5\", \"6\", \"7\", \"8\"]', 8, 'C'),
(254, 'If 3x - 9 = 0, what is x?', '[\"2\", \"3\", \"4\", \"5\"]', 8, 'B'),
(255, 'Simplify: x + x + x = 9.', '[\"1\", \"2\", \"3\", \"4\"]', 8, 'C'),
(256, 'Solve for x: 2x = 14.', '[\"5\", \"6\", \"7\", \"8\"]', 8, 'C'),
(257, 'If x - 4 = 10, what is x?', '[\"12\", \"13\", \"14\", \"15\"]', 8, 'C'),
(258, 'Solve: 9x = 81.', '[\"7\", \"8\", \"9\", \"10\"]', 8, 'C'),
(259, 'What is the value of x if 5x - 5 = 20?', '[\"4\", \"5\", \"6\", \"7\"]', 8, 'D'),
(260, 'If 8x = 64, what is x?', '[\"6\", \"7\", \"8\", \"9\"]', 8, 'C'),
(261, 'Simplify: 2x = 18.', '[\"7\", \"8\", \"9\", \"10\"]', 8, 'C'),
(262, 'What is x in x/5 = 6?', '[\"25\", \"30\", \"35\", \"40\"]', 8, 'B'),
(263, 'Solve for x: x - 7 = 0.', '[\"5\", \"6\", \"7\", \"8\"]', 8, 'C'),
(264, 'Who discovered the law of gravity?', '[\"Albert Einstein\", \"Isaac Newton\", \"Galileo Galilei\", \"Nikola Tesla\"]', 9, 'B'),
(265, 'What is the speed of light in a vacuum?', '[\"300,000 km/s\", \"150,000 km/s\", \"400,000 km/s\", \"200,000 km/s\"]', 9, 'A'),
(266, 'Who developed the theory of relativity?', '[\"Isaac Newton\", \"Albert Einstein\", \"Stephen Hawking\", \"Marie Curie\"]', 9, 'B'),
(267, 'What is the primary component of the sun?', '[\"Oxygen\", \"Hydrogen\", \"Carbon\", \"Helium\"]', 9, 'B'),
(268, 'Which invention is attributed to Alexander Fleming?', '[\"Telephone\", \"Penicillin\", \"X-ray\", \"Radar\"]', 9, 'B'),
(269, 'What particle was discovered at CERN in 2012?', '[\"Photon\", \"Higgs boson\", \"Quark\", \"Electron\"]', 9, 'B'),
(270, 'What is CRISPR technology used for?', '[\"Genetic editing\", \"Space exploration\", \"Quantum computing\", \"AI development\"]', 9, 'A'),
(271, 'Which planet is known for its rings?', '[\"Mars\", \"Venus\", \"Saturn\", \"Jupiter\"]', 9, 'C'),
(272, 'Who is known as the father of modern physics?', '[\"Albert Einstein\", \"Isaac Newton\", \"Max Planck\", \"Galileo Galilei\"]', 9, 'A'),
(273, 'What does DNA stand for?', '[\"Deoxyribonucleic Acid\", \"Dioxygen Nucleic Acid\", \"Dinucleic Acid\", \"Deoxyribosome Acid\"]', 9, 'A'),
(274, 'Which scientist proposed the heliocentric model?', '[\"Aristotle\", \"Copernicus\", \"Ptolemy\", \"Kepler\"]', 9, 'B'),
(275, 'What is the chemical symbol for water?', '[\"O2\", \"H2O\", \"HO2\", \"H3O\"]', 9, 'B'),
(276, 'What is the term for animals that live on land and water?', '[\"Herbivores\", \"Carnivores\", \"Omnivores\", \"Amphibians\"]', 9, 'D'),
(277, 'Which device is used to measure earthquakes?', '[\"Barometer\", \"Seismograph\", \"Thermometer\", \"Anemometer\"]', 9, 'B'),
(278, 'What is the process of splitting an atom called?', '[\"Nuclear fusion\", \"Nuclear fission\", \"Radioactive decay\", \"Electron capture\"]', 9, 'B'),
(279, 'Which planet is called the Red Planet?', '[\"Venus\", \"Mars\", \"Jupiter\", \"Mercury\"]', 9, 'B'),
(280, 'Who discovered radioactivity?', '[\"Marie Curie\", \"Henri Becquerel\", \"Thomas Edison\", \"James Clerk Maxwell\"]', 9, 'B'),
(281, 'What is the powerhouse of the cell?', '[\"Nucleus\", \"Ribosome\", \"Mitochondria\", \"Golgi apparatus\"]', 9, 'C'),
(282, 'What does a light-year measure?', '[\"Time\", \"Distance\", \"Speed\", \"Mass\"]', 9, 'B'),
(283, 'Who invented the first successful airplane?', '[\"Wright Brothers\", \"Henry Ford\", \"Nikola Tesla\", \"Leonardo da Vinci\"]', 9, 'A'),
(284, 'Who won the Best Actor Oscar in 2023?', '[\"Austin Butler\", \"Brendan Fraser\", \"Colin Farrell\", \"Paul Mescal\"]', 10, 'B'),
(285, 'Which movie won Best Picture in 2022?', '[\"Dune\", \"The Power of the Dog\", \"CODA\", \"Belfast\"]', 10, 'C'),
(286, 'Who was the first woman to win the Best Director Oscar?', '[\"Kathryn Bigelow\", \"Sofia Coppola\", \"Greta Gerwig\", \"Jane Campion\"]', 10, 'A'),
(287, 'Which film holds the record for the most Oscars won?', '[\"Titanic\", \"Ben-Hur\", \"The Lord of the Rings: The Return of the King\", \"All of the above\"]', 10, 'D'),
(288, 'Who won the Best Actress Oscar for *Black Swan*?', '[\"Meryl Streep\", \"Sandra Bullock\", \"Natalie Portman\", \"Cate Blanchett\"]', 10, 'C'),
(289, 'Which actor has won the most Oscars?', '[\"Jack Nicholson\", \"Daniel Day-Lewis\", \"Marlon Brando\", \"Katharine Hepburn\"]', 10, 'D'),
(290, 'What was the first animated movie nominated for Best Picture?', '[\"Beauty and the Beast\", \"The Lion King\", \"Toy Story\", \"Shrek\"]', 10, 'A'),
(291, 'Which director has the most Oscar wins?', '[\"Steven Spielberg\", \"James Cameron\", \"John Ford\", \"Francis Ford Coppola\"]', 10, 'C'),
(292, 'Who won the Best Supporting Actress Oscar in 2021 for *Minari*?', '[\"Youn Yuh-jung\", \"Glenn Close\", \"Maria Bakalova\", \"Amanda Seyfried\"]', 10, 'A'),
(293, 'What was the first foreign-language film to win Best Picture?', '[\"Crouching Tiger, Hidden Dragon\", \"Roma\", \"Parasite\", \"Life is Beautiful\"]', 10, 'C'),
(294, 'Which movie won Best Picture in 1997?', '[\"Good Will Hunting\", \"Titanic\", \"LA Confidential\", \"The Full Monty\"]', 10, 'B'),
(295, 'Who is the only actor to win an Oscar for playing a U.S. president?', '[\"Daniel Day-Lewis\", \"Gary Oldman\", \"Anthony Hopkins\", \"Tom Hanks\"]', 10, 'A'),
(296, 'Who won Best Actor for *The Revenant*?', '[\"Leonardo DiCaprio\", \"Brad Pitt\", \"Matt Damon\", \"Michael Fassbender\"]', 10, 'A'),
(297, 'What is the nickname of the Oscar statuette?', '[\"Golden Knight\", \"The Gold Man\", \"Oscar\", \"The Academy Figure\"]', 10, 'C'),
(298, 'Who is the youngest person to win an Oscar?', '[\"Anna Paquin\", \"Tatum O’Neal\", \"Shirley Temple\", \"Haley Joel Osment\"]', 10, 'B'),
(299, 'Which movie was the first to win all five major Academy Awards?', '[\"Titanic\", \"It Happened One Night\", \"One Flew Over the Cuckoo\'s Nest\", \"The Silence of the Lambs\"]', 10, 'B'),
(300, 'Who won Best Actress for *La La Land*?', '[\"Emma Stone\", \"Amy Adams\", \"Brie Larson\", \"Margot Robbie\"]', 10, 'A'),
(301, 'Which actor won a posthumous Oscar for *The Dark Knight*?', '[\"Heath Ledger\", \"Philip Seymour Hoffman\", \"James Dean\", \"Robin Williams\"]', 10, 'A'),
(302, 'Which film won Best Picture in 2000?', '[\"Gladiator\", \"Traffic\", \"Crouching Tiger, Hidden Dragon\", \"Erin Brockovich\"]', 10, 'A'),
(303, 'Who hosted the Oscars the most times?', '[\"Billy Crystal\", \"Bob Hope\", \"Ellen DeGeneres\", \"Jimmy Kimmel\"]', 10, 'B'),
(304, 'Who wrote *Pride and Prejudice*?', '[\"Charlotte Brontë\", \"Jane Austen\", \"Emily Brontë\", \"Mary Shelley\"]', 11, 'B'),
(305, 'Who is the author of *Moby-Dick*?', '[\"Herman Melville\", \"Nathaniel Hawthorne\", \"Mark Twain\", \"Edgar Allan Poe\"]', 11, 'A'),
(306, 'Who wrote *Crime and Punishment*?', '[\"Leo Tolstoy\", \"Fyodor Dostoevsky\", \"Anton Chekhov\", \"Alexander Pushkin\"]', 11, 'B'),
(307, 'Who is the author of *The Great Gatsby*?', '[\"Ernest Hemingway\", \"F. Scott Fitzgerald\", \"William Faulkner\", \"John Steinbeck\"]', 11, 'B'),
(308, 'Who wrote *1984*?', '[\"Aldous Huxley\", \"George Orwell\", \"Ray Bradbury\", \"Arthur C. Clarke\"]', 11, 'B'),
(309, 'Who wrote *The Catcher in the Rye*?', '[\"J.D. Salinger\", \"John Steinbeck\", \"F. Scott Fitzgerald\", \"Jack Kerouac\"]', 11, 'A'),
(310, 'Who wrote *To Kill a Mockingbird*?', '[\"Harper Lee\", \"Toni Morrison\", \"Margaret Atwood\", \"Alice Walker\"]', 11, 'A'),
(311, 'Who wrote *Wuthering Heights*?', '[\"Emily Brontë\", \"Charlotte Brontë\", \"Jane Austen\", \"George Eliot\"]', 11, 'A'),
(312, 'Who wrote *Don Quixote*?', '[\"Miguel de Cervantes\", \"Gabriel García Márquez\", \"Jorge Luis Borges\", \"Pablo Neruda\"]', 11, 'A'),
(313, 'Who is the author of *Les Misérables*?', '[\"Victor Hugo\", \"Alexandre Dumas\", \"Émile Zola\", \"Gustave Flaubert\"]', 11, 'A'),
(314, 'Who wrote *The Odyssey*?', '[\"Homer\", \"Virgil\", \"Sophocles\", \"Plato\"]', 11, 'A'),
(315, 'Who wrote *War and Peace*?', '[\"Fyodor Dostoevsky\", \"Leo Tolstoy\", \"Alexander Pushkin\", \"Anton Chekhov\"]', 11, 'B'),
(316, 'Who is the author of *Frankenstein*?', '[\"Mary Shelley\", \"Bram Stoker\", \"Percy Shelley\", \"Lord Byron\"]', 11, 'A'),
(317, 'Who wrote *A Tale of Two Cities*?', '[\"Charles Dickens\", \"Thomas Hardy\", \"William Makepeace Thackeray\", \"Anthony Trollope\"]', 11, 'A'),
(318, 'Who wrote *The Scarlet Letter*?', '[\"Nathaniel Hawthorne\", \"Herman Melville\", \"Ralph Waldo Emerson\", \"Henry David Thoreau\"]', 11, 'A'),
(319, 'Who wrote *Dracula*?', '[\"Mary Shelley\", \"Bram Stoker\", \"Oscar Wilde\", \"Robert Louis Stevenson\"]', 11, 'B'),
(320, 'Who is the author of *The Picture of Dorian Gray*?', '[\"Oscar Wilde\", \"George Bernard Shaw\", \"Bram Stoker\", \"Thomas Hardy\"]', 11, 'A'),
(321, 'Who wrote *Of Mice and Men*?', '[\"John Steinbeck\", \"Ernest Hemingway\", \"William Faulkner\", \"Jack London\"]', 11, 'A'),
(322, 'Who wrote *Jane Eyre*?', '[\"Emily Brontë\", \"Charlotte Brontë\", \"Jane Austen\", \"George Eliot\"]', 11, 'B'),
(323, 'Who wrote *The Divine Comedy*?', '[\"Dante Alighieri\", \"Geoffrey Chaucer\", \"John Milton\", \"Homer\"]', 11, 'A'),
(324, 'Who won the most Olympic gold medals?', '[\"Usain Bolt\", \"Michael Phelps\", \"Larisa Latynina\", \"Paavo Nurmi\"]', 12, 'B'),
(325, 'Which tennis player has the most Grand Slam singles titles?', '[\"Roger Federer\", \"Rafael Nadal\", \"Novak Djokovic\", \"Serena Williams\"]', 12, 'C'),
(326, 'Who is known as the “King of Football”?', '[\"Lionel Messi\", \"Pele\", \"Cristiano Ronaldo\", \"Diego Maradona\"]', 12, 'B'),
(327, 'Which basketball player is known for the “Air Jordan” brand?', '[\"LeBron James\", \"Michael Jordan\", \"Kobe Bryant\", \"Stephen Curry\"]', 12, 'B'),
(328, 'Who is the fastest man in the world?', '[\"Michael Johnson\", \"Usain Bolt\", \"Carl Lewis\", \"Tyson Gay\"]', 12, 'B'),
(329, 'Who holds the record for the most goals in a single World Cup?', '[\"Ronaldo Nazário\", \"Miroslav Klose\", \"Just Fontaine\", \"Pele\"]', 12, 'C'),
(330, 'Who is the only boxer to hold all four major world titles simultaneously?', '[\"Manny Pacquiao\", \"Floyd Mayweather\", \"Canelo Álvarez\", \"Sugar Ray Leonard\"]', 12, 'C'),
(331, 'Which footballer won five Ballon d’Or awards in the 2010s?', '[\"Cristiano Ronaldo\", \"Lionel Messi\", \"Neymar\", \"Kaka\"]', 12, 'B'),
(332, 'Who is the most successful Formula 1 driver of all time?', '[\"Lewis Hamilton\", \"Michael Schumacher\", \"Ayrton Senna\", \"Sebastian Vettel\"]', 12, 'A'),
(333, 'Who holds the record for most NBA championships?', '[\"LeBron James\", \"Kobe Bryant\", \"Michael Jordan\", \"Bill Russell\"]', 12, 'D'),
(334, 'Who is the highest-paid athlete of all time?', '[\"Lionel Messi\", \"Cristiano Ronaldo\", \"Michael Jordan\", \"Floyd Mayweather\"]', 12, 'D'),
(335, 'Which golfer has the most major championships?', '[\"Tiger Woods\", \"Jack Nicklaus\", \"Arnold Palmer\", \"Gary Player\"]', 12, 'B'),
(336, 'Who is known as the “Great One” in ice hockey?', '[\"Wayne Gretzky\", \"Mario Lemieux\", \"Bobby Orr\", \"Sidney Crosby\"]', 12, 'A'),
(337, 'Who won the first women’s tennis Grand Slam?', '[\"Serena Williams\", \"Martina Navratilova\", \"Billie Jean King\", \"Venus Williams\"]', 12, 'C'),
(338, 'Who holds the record for the most home runs in Major League Baseball?', '[\"Barry Bonds\", \"Hank Aaron\", \"Babe Ruth\", \"Alex Rodriguez\"]', 12, 'A'),
(339, 'Which NBA player is known for his “Sky Hook” shot?', '[\"Shaquille O’Neal\", \"Kareem Abdul-Jabbar\", \"Tim Duncan\", \"Michael Jordan\"]', 12, 'B'),
(340, 'Who is the all-time top scorer in international football?', '[\"Lionel Messi\", \"Cristiano Ronaldo\", \"Pele\", \"Ali Daei\"]', 12, 'B'),
(341, 'Who is the most decorated Olympian of all time?', '[\"Michael Phelps\", \"Larisa Latynina\", \"Paavo Nurmi\", \"Mark Spitz\"]', 12, 'A'),
(342, 'Which tennis player is nicknamed the “Swiss Maestro”?', '[\"Rafael Nadal\", \"Roger Federer\", \"Novak Djokovic\", \"Andy Murray\"]', 12, 'B'),
(343, 'Who won the first FIFA World Cup in 1930?', '[\"Germany\", \"Brazil\", \"Argentina\", \"Uruguay\"]', 12, 'D'),
(344, 'What is GDP an abbreviation for?', '[\"Gross Domestic Product\", \"Gross Debt Product\", \"Global Development Progress\", \"General Domestic Price\"]', 13, 'A'),
(345, 'What does inflation measure?', '[\"The rise in employment\", \"The increase in money supply\", \"The rise in prices of goods and services\", \"The increase in interest rates\"]', 13, 'C'),
(346, 'What is the primary goal of monetary policy?', '[\"Control inflation\", \"Increase taxation\", \"Reduce government debt\", \"Boost export rates\"]', 13, 'A'),
(347, 'Which of the following is an example of a public good?', '[\"National defense\", \"Healthcare\", \"Cars\", \"Smartphones\"]', 13, 'A'),
(348, 'What does a supply curve represent?', '[\"The quantity of goods available at each price\", \"The amount of money available in the economy\", \"The number of consumers in a market\", \"The total demand for goods\"]', 13, 'A'),
(349, 'What is the law of demand?', '[\"As price increases, demand increases\", \"As price decreases, demand decreases\", \"As price increases, demand decreases\", \"Price and demand are unrelated\"]', 13, 'C'),
(350, 'What is a market economy?', '[\"An economy controlled by the government\", \"An economy where prices are determined by supply and demand\", \"An economy based on bartering\", \"An economy with no regulations\"]', 13, 'B'),
(351, 'What is the definition of opportunity cost?', '[\"The cost of the next best alternative foregone when a decision is made\", \"The total cost of production\", \"The cost of all resources used in production\", \"The cost of raw materials\"]', 13, 'A'),
(352, 'What is meant by “fiscal policy”?', '[\"Government adjustments to its spending and taxation to influence the economy\", \"Central bank policies to control money supply\", \"Policies to regulate international trade\", \"Taxation policies for individuals\"]', 13, 'A'),
(353, 'What is a recession?', '[\"A period of rapid economic growth\", \"A period of rising inflation\", \"A period of decline in economic activity\", \"A period of increased employment\"]', 13, 'C'),
(354, 'What is the purpose of central banks?', '[\"To set interest rates and manage money supply\", \"To regulate businesses\", \"To enforce labor laws\", \"To manage government expenditure\"]', 13, 'A'),
(355, 'What does the term “capital” refer to in economics?', '[\"Machines and tools used for production\", \"Natural resources like land and water\", \"Money used for investment\", \"Labor employed in production\"]', 13, 'C'),
(356, 'What is the meaning of the term “market equilibrium”?', '[\"When supply equals demand\", \"When supply is greater than demand\", \"When demand is greater than supply\", \"When the price is fixed\"]', 13, 'A'),
(357, 'What is “price elasticity of demand”?', '[\"How sensitive demand is to changes in price\", \"How sensitive supply is to changes in price\", \"The total demand for a product\", \"The total supply of a product\"]', 13, 'A'),
(358, 'What is meant by “comparative advantage”?', '[\"The ability of a country to produce a good at a lower opportunity cost than another country\", \"The ability to produce more of a good than other countries\", \"The ability to restrict imports\", \"The ability to dominate a market\"]', 13, 'A'),
(359, 'What is the purpose of tariffs in international trade?', '[\"To encourage exports\", \"To protect domestic industries\", \"To increase the supply of goods\", \"To reduce government revenue\"]', 13, 'B'),
(360, 'What is “monetary policy”?', '[\"The management of money supply and interest rates by a government or central bank\", \"The regulation of government spending\", \"The setting of tax rates\", \"The regulation of wages\"]', 13, 'A'),
(361, 'What is the “invisible hand” in economics?', '[\"A metaphor for self-regulating behavior of the marketplace\", \"A government policy to control inflation\", \"A method of managing trade balances\", \"A type of economic theory\"]', 13, 'A'),
(362, 'What does “laissez-faire” mean in economics?', '[\"Government should intervene in the economy\", \"No government intervention in the economy\", \"Government sets prices\", \"Government regulates markets\"]', 13, 'B'),
(363, 'What does “stagflation” refer to?', '[\"High inflation combined with high unemployment and stagnant demand\", \"High economic growth\", \"High inflation and low unemployment\", \"Low inflation and high demand\"]', 13, 'A'),
(364, 'Choose the correct sentence.', '[\"She go to school every day.\", \"She goes to school every day.\", \"She going to school every day.\", \"She gone to school every day.\"]', 15, 'B'),
(365, 'What is the synonym of “happy”?', '[\"Sad\", \"Excited\", \"Joyful\", \"Angry\"]', 15, 'C'),
(366, 'Which word is an antonym of “difficult”?', '[\"Easy\", \"Hard\", \"Complicated\", \"Challenging\"]', 15, 'A'),
(367, 'Choose the correct sentence.', '[\"I can plays the piano.\", \"I can play the piano.\", \"I can playing the piano.\", \"I can played the piano.\"]', 15, 'B'),
(368, 'What is the past tense of “run”?', '[\"Runned\", \"Ran\", \"Running\", \"Runed\"]', 15, 'B'),
(369, 'Which of the following is a noun?', '[\"Quickly\", \"Swim\", \"Happiness\", \"Easily\"]', 15, 'C'),
(370, 'Choose the correct word: She has a ____ in her hand.', '[\"book\", \"books\", \"booked\", \"booking\"]', 15, 'A'),
(371, 'What is the plural of “child”?', '[\"Children\", \"Childs\", \"Childrens\", \"Childer\"]', 15, 'A'),
(372, 'What is the antonym of “increase”?', '[\"Raise\", \"Lift\", \"Decrease\", \"Grow\"]', 15, 'C'),
(373, 'What is the meaning of the word “benevolent”?', '[\"Cruel\", \"Kind\", \"Angry\", \"Miserly\"]', 15, 'B'),
(374, 'Choose the correct sentence.', '[\"I have ate lunch.\", \"I have eaten lunch.\", \"I have eating lunch.\", \"I have eat lunch.\"]', 15, 'B'),
(375, 'What is the meaning of “ambiguous”?', '[\"Clear\", \"Uncertain\", \"Obvious\", \"Bright\"]', 15, 'B'),
(376, 'What is the synonym of “scarcity”?', '[\"Abundance\", \"Plenty\", \"Shortage\", \"Overflow\"]', 15, 'C'),
(377, 'Which of the following words is an adjective?', '[\"Quick\", \"Run\", \"Happiness\", \"Joyfully\"]', 15, 'A'),
(378, 'What is the past tense of “go”?', '[\"Went\", \"Gone\", \"Going\", \"Goes\"]', 15, 'A'),
(379, 'Choose the correct sentence.', '[\"She don’t like pizza.\", \"She doesn’t like pizza.\", \"She don’t likes pizza.\", \"She doesn’t likes pizza.\"]', 15, 'B'),
(380, 'Which word is an antonym of “strong”?', '[\"Weak\", \"Powerful\", \"Hard\", \"Forceful\"]', 15, 'A'),
(381, 'What is the plural form of “fox”?', '[\"Foxes\", \"Foxeses\", \"Fox\", \"Foxii\"]', 15, 'A'),
(382, 'Choose the correct word: He ____ a book every week.', '[\"read\", \"reads\", \"reading\", \"reader\"]', 15, 'B'),
(383, 'What is the synonym of “brilliant”?', '[\"Dull\", \"Bright\", \"Slow\", \"Boring\"]', 15, 'B'),
(384, 'What does “AI” stand for in technology?', '[\"Artificial Intelligence\", \"Automated Interface\", \"Artificial Integration\", \"Automatic Intelligence\"]', 16, 'A'),
(385, 'Which company developed the first iPhone?', '[\"Google\", \"Microsoft\", \"Apple\", \"Samsung\"]', 16, 'C'),
(386, 'What year was the first iPhone released?', '[\"2007\", \"2006\", \"2008\", \"2010\"]', 16, 'A'),
(387, 'What does the “cloud” refer to in technology?', '[\"A physical storage unit\", \"A data storage service over the internet\", \"A type of network connection\", \"A new software\"]', 16, 'B'),
(388, 'Which technology is used in virtual reality?', '[\"Bluetooth\", \"3D modeling\", \"Augmented reality\", \"Headsets and motion sensors\"]', 16, 'D'),
(389, 'What does the term “big data” refer to?', '[\"Data from large databases\", \"Data that is too big to manage\", \"Large amounts of data analyzed for insights\", \"Personalized data\"]', 16, 'C'),
(390, 'Which programming language is primarily used for web development?', '[\"Python\", \"Java\", \"JavaScript\", \"C#\"]', 16, 'C'),
(391, 'Which company is known for its social media platform Facebook?', '[\"Microsoft\", \"Google\", \"Apple\", \"Meta\"]', 16, 'D'),
(392, 'What is the primary function of a CPU in a computer?', '[\"Storing data\", \"Performing calculations\", \"Displaying images\", \"Reading inputs\"]', 16, 'B'),
(393, 'Which of the following is not a type of machine learning?', '[\"Supervised learning\", \"Unsupervised learning\", \"Reinforcement learning\", \"Data learning\"]', 16, 'D'),
(394, 'What is the term for a network of interconnected devices?', '[\"Internet of Things\", \"Virtual reality\", \"Digital network\", \"Cloud computing\"]', 16, 'A'),
(395, 'What does “5G” refer to in mobile technology?', '[\"Fifth Generation wireless technology\", \"Global positioning system\", \"A new type of mobile phone\", \"Fifth Geolocation technology\"]', 16, 'A'),
(396, 'Which company developed the Android operating system?', '[\"Google\", \"Apple\", \"Microsoft\", \"Samsung\"]', 16, 'A'),
(397, 'What is blockchain technology primarily used for?', '[\"Data encryption\", \"Cryptocurrency transactions\", \"File sharing\", \"Cloud storage\"]', 16, 'B'),
(398, 'What does the term “cybersecurity” refer to?', '[\"Protecting against physical threats\", \"Protecting digital information from unauthorized access\", \"Ensuring device functionality\", \"Data storage\"]', 16, 'B'),
(399, 'What is the main function of a router in networking?', '[\"To store data\", \"To send data between different networks\", \"To encrypt data\", \"To process requests\"]', 16, 'B'),
(400, 'What does “IoT” stand for?', '[\"Internet of Technology\", \"Internet of Things\", \"Integrated Online Tools\", \"Intelligent Online Tracking\"]', 16, 'B'),
(401, 'What is the largest social media platform by active users?', '[\"Facebook\", \"Instagram\", \"Twitter\", \"TikTok\"]', 16, 'A'),
(402, 'What is the main purpose of 3D printing technology?', '[\"To print digital documents\", \"To create three-dimensional objects from a digital model\", \"To make copies of pictures\", \"To create artificial intelligence\"]', 16, 'B'),
(403, 'Which virtual assistant was developed by Amazon?', '[\"Siri\", \"Cortana\", \"Alexa\", \"Google Assistant\"]', 16, 'C'),
(404, 'Who was known as the “King of Pop” in the 2000s?', '[\"Michael Jackson\", \"Elvis Presley\", \"Prince\", \"Justin Timberlake\"]', 17, 'A'),
(405, 'Which actress starred as “Buffy the Vampire Slayer”?', '[\"Sarah Michelle Gellar\", \"Jennifer Aniston\", \"Lucy Liu\", \"Angelina Jolie\"]', 17, 'A'),
(406, 'What was the name of the popular boy band formed in the late 1990s with members like Justin Timberlake and JC Chasez?', '[\"Backstreet Boys\", \"N*SYNC\", \"98 Degrees\", \"O-Town\"]', 17, 'B'),
(407, 'Who won the first season of “American Idol” in 2002?', '[\"Kelly Clarkson\", \"Clay Aiken\", \"Justin Guarini\", \"Carrie Underwood\"]', 17, 'A'),
(408, 'Which actor played Tony Stark in the Marvel Cinematic Universe?', '[\"Chris Hemsworth\", \"Robert Downey Jr.\", \"Chris Evans\", \"Mark Ruffalo\"]', 17, 'B'),
(409, 'Who was known for the catchphrase “You’re Fired!” on The Apprentice?', '[\"Donald Trump\", \"Simon Cowell\", \"Tyra Banks\", \"Mark Cuban\"]', 17, 'A'),
(410, 'What famous 2000s show featured the characters Rachel, Ross, Monica, Chandler, Joey, and Phoebe?', '[\"Friends\", \"How I Met Your Mother\", \"The Office\", \"The Big Bang Theory\"]', 17, 'A'),
(411, 'Which reality TV star became famous for saying “That’s hot!”?', '[\"Paris Hilton\", \"Kim Kardashian\", \"Nicole Richie\", \"Kourtney Kardashian\"]', 17, 'A'),
(412, 'Which iconic 2000s song did Britney Spears release in 2003?', '[\"Toxic\", \"Oops!... I Did It Again\", \"Baby One More Time\", \"Im a Slave 4 U\"]', 17, 'A'),
(413, 'Who was the lead singer of the band The White Stripes?', '[\"Jack White\", \"John Mayer\", \"Dave Grohl\", \"Billy Joe Armstrong\"]', 17, 'A'),
(414, 'Which actor starred as Edward Cullen in the “Twilight” series?', '[\"Robert Pattinson\", \"Taylor Lautner\", \"Kristen Stewart\", \"Shia LaBeouf\"]', 17, 'A'),
(415, 'What famous movie franchise was known for “The Matrix” trilogy in the early 2000s?', '[\"Star Wars\", \"The Lord of the Rings\", \"The Matrix\", \"Harry Potter\"]', 17, 'C'),
(416, 'Who was the breakout star of the 2004 film “Mean Girls”?', '[\"Lindsay Lohan\", \"Rachel McAdams\", \"Amanda Seyfried\", \"Tina Fey\"]', 17, 'A'),
(417, 'Which popular TV show was centered around a high school in Beverly Hills?', '[\"The OC\", \"90210\", \"Gossip Girl\", \"One Tree Hill\"]', 17, 'B'),
(418, 'Which song by OutKast became a huge hit in the 2000s?', '[\"Hey Ya!\", \"Ms. Jackson\", \"The Way You Move\", \"Roses\"]', 17, 'A'),
(419, 'What was the name of the social media platform launched in 2004 by Mark Zuckerberg?', '[\"MySpace\", \"Instagram\", \"Facebook\", \"Twitter\"]', 17, 'C'),
(420, 'Who was the first female artist to win “Artist of the Year” at the MTV Video Music Awards in 2002?', '[\"Beyoncé\", \"Britney Spears\", \"Christina Aguilera\", \"Pink\"]', 17, 'B'),
(421, 'Which actor famously said, “I’m not a businessman, I’m a business, man!”?', '[\"Jay-Z\", \"Kanye West\", \"Snoop Dogg\", \"Diddy\"]', 17, 'A'),
(422, 'Which singer’s 2006 album “Back to Black” was a huge success in the 2000s?', '[\"Amy Winehouse\", \"Lily Allen\", \"Duffy\", \"Norah Jones\"]', 17, 'A'),
(423, 'What is the name of the movie that launched the career of the “Pirates of the Caribbean” franchise?', '[\"Pirates of the Caribbean: The Curse of the Black Pearl\", \"Pirates of the Caribbean: Dead Man’s Chest\", \"Pirates of the Caribbean: At World’s End\", \"Pirates of the Caribbean: On Stranger Tides\"]', 17, 'A'),
(424, 'Which country recently became the first in the world to legalize the sale of cannabis for recreational use?', '[\"Canada\", \"Netherlands\", \"Uruguay\", \"Portugal\"]', 18, 'A'),
(425, 'In which year did the UK officially leave the European Union?', '[\"2018\", \"2020\", \"2019\", \"2021\"]', 18, 'B'),
(426, 'Which country hosted the 2022 FIFA World Cup?', '[\"Russia\", \"Qatar\", \"Brazil\", \"South Korea\"]', 18, 'B'),
(427, 'Who was the first female vice president of the United States?', '[\"Kamala Harris\", \"Hillary Clinton\", \"Nancy Pelosi\", \"Condoleezza Rice\"]', 18, 'A'),
(428, 'Which country launched the first successful human mission to Mars?', '[\"China\", \"USA\", \"Russia\", \"India\"]', 18, 'B'),
(429, 'Which global health organization declared COVID-19 a global pandemic in March 2020?', '[\"UNICEF\", \"World Health Organization\", \"CDC\", \"Red Cross\"]', 18, 'B'),
(430, 'Which country became the world’s most populous nation in 2023?', '[\"India\", \"China\", \"United States\", \"Indonesia\"]', 18, 'A'),
(431, 'In which country did the 2022 Russian invasion take place?', '[\"Ukraine\", \"Poland\", \"Belarus\", \"Georgia\"]', 18, 'A'),
(432, 'Which country has the highest number of COVID-19 vaccinations administered as of 2023?', '[\"China\", \"United States\", \"India\", \"Germany\"]', 18, 'A'),
(433, 'Which country announced its decision to host the 2024 Summer Olympics?', '[\"Japan\", \"France\", \"USA\", \"Australia\"]', 18, 'B'),
(434, 'Which country was the first to achieve net-zero carbon emissions by 2050?', '[\"Germany\", \"United Kingdom\", \"New Zealand\", \"Costa Rica\"]', 18, 'B'),
(435, 'Who was awarded the 2021 Nobel Peace Prize?', '[\"Greta Thunberg\", \"Abiy Ahmed Ali\", \"Maria Ressa\", \"Malala Yousafzai\"]', 18, 'B'),
(436, 'Which country became the first to achieve the Paris Climate Agreement’s carbon emission reduction targets in 2020?', '[\"United Kingdom\", \"France\", \"Germany\", \"New Zealand\"]', 18, 'A'),
(437, 'Which continent has the highest number of refugees due to conflict?', '[\"Asia\", \"Europe\", \"Africa\", \"South America\"]', 18, 'C'),
(438, 'Which global event was canceled for the first time in its history in 2020 due to the pandemic?', '[\"Cannes Film Festival\", \"World Economic Forum\", \"Olympic Games\", \"World Cup\"]', 18, 'C'),
(439, 'In which year did the United Nations officially declare the climate crisis as an emergency?', '[\"2020\", \"2019\", \"2018\", \"2021\"]', 18, 'A'),
(440, 'Which international organization is focused on reducing global poverty and ensuring sustainable development?', '[\"World Bank\", \"UNICEF\", \"World Economic Forum\", \"World Health Organization\"]', 18, 'A'),
(441, 'What country has faced significant political unrest and protests since the 2019 Hong Kong protests?', '[\"China\", \"Taiwan\", \"Hong Kong\", \"South Korea\"]', 18, 'C'),
(442, 'In which country did the 2019 Notre-Dame Cathedral fire occur?', '[\"Italy\", \"France\", \"Germany\", \"Spain\"]', 18, 'B'),
(443, 'Which country is the worlds largest producer of electric vehicles as of 2023?', '[\"China\", \"United States\", \"Germany\", \"Japan\"]', 18, 'A'),
(444, 'What is 5 + 3?', '[\"7\", \"8\", \"9\", \"10\"]', 19, 'B'),
(445, 'What is 12 - 4?', '[\"6\", \"7\", \"8\", \"9\"]', 19, 'C'),
(446, 'What is 3 x 6?', '[\"12\", \"15\", \"18\", \"21\"]', 19, 'C'),
(447, 'What is 15 ÷ 3?', '[\"3\", \"4\", \"5\", \"6\"]', 19, 'C'),
(448, 'What is 7 + 9?', '[\"14\", \"15\", \"16\", \"17\"]', 19, 'D'),
(449, 'What is 10 x 2?', '[\"10\", \"12\", \"20\", \"25\"]', 19, 'C'),
(450, 'What is 9 - 5?', '[\"3\", \"4\", \"5\", \"6\"]', 19, 'B'),
(451, 'What is 6 ÷ 2?', '[\"2\", \"3\", \"4\", \"5\"]', 19, 'B'),
(452, 'What is 5 x 5?', '[\"20\", \"25\", \"30\", \"35\"]', 19, 'B'),
(453, 'What is 8 ÷ 4?', '[\"1\", \"2\", \"3\", \"4\"]', 19, 'B'),
(454, 'What is 20 - 7?', '[\"11\", \"12\", \"13\", \"14\"]', 19, 'C'),
(455, 'What is 11 + 6?', '[\"15\", \"16\", \"17\", \"18\"]', 19, 'A'),
(456, 'What is 2 x 8?', '[\"14\", \"15\", \"16\", \"18\"]', 19, 'C'),
(457, 'What is 18 ÷ 3?', '[\"5\", \"6\", \"7\", \"8\"]', 19, 'B'),
(458, 'What is 13 - 9?', '[\"3\", \"4\", \"5\", \"6\"]', 19, 'C'),
(459, 'What is 4 x 7?', '[\"26\", \"28\", \"30\", \"32\"]', 19, 'B'),
(460, 'What is 14 ÷ 2?', '[\"5\", \"6\", \"7\", \"8\"]', 19, 'C'),
(461, 'What is 3 + 6?', '[\"7\", \"8\", \"9\", \"10\"]', 19, 'C'),
(462, 'What is 10 - 3?', '[\"6\", \"7\", \"8\", \"9\"]', 19, 'A'),
(463, 'What is 7 x 2?', '[\"12\", \"13\", \"14\", \"15\"]', 19, 'C'),
(464, 'Which art movement is associated with artists like Pablo Picasso and Georges Braque?', '[\"Surrealism\", \"Cubism\", \"Impressionism\", \"Expressionism\"]', 20, 'B'),
(465, 'Who is considered the father of modern abstract painting?', '[\"Vincent van Gogh\", \"Pablo Picasso\", \"Wassily Kandinsky\", \"Claude Monet\"]', 20, 'C'),
(466, 'Which art movement focused on light and color, often with outdoor scenes?', '[\"Impressionism\", \"Realism\", \"Cubism\", \"Renaissance\"]', 20, 'A'),
(467, 'Which of the following artists is known for his role in the Dada movement?', '[\"Salvador Dalí\", \"Marcel Duchamp\", \"Henri Matisse\", \"Michelangelo\"]', 20, 'B'),
(468, 'Which movement is known for its dreamlike imagery and bizarre scenes?', '[\"Surrealism\", \"Expressionism\", \"Renaissance\", \"Fauvism\"]', 20, 'A'),
(469, 'What is the primary characteristic of Baroque art?', '[\"Use of abstract shapes\", \"Bold colors and dramatic contrasts\", \"Focus on naturalism\", \"Emphasis on geometric forms\"]', 20, 'B'),
(470, 'Which artist is associated with the Pop Art movement?', '[\"Claude Monet\", \"Andy Warhol\", \"Pablo Picasso\", \"Edvard Munch\"]', 20, 'B'),
(471, 'In which country did the Impressionist movement originate?', '[\"United States\", \"France\", \"Italy\", \"Germany\"]', 20, 'B'),
(472, 'Who is the famous artist behind the \"Starry Night\" painting?', '[\"Vincent van Gogh\", \"Leonardo da Vinci\", \"Salvador Dalí\", \"Henri Matisse\"]', 20, 'A'),
(473, 'Which movement was directly influenced by World War I and sought to challenge cultural norms?', '[\"Dada\", \"Art Nouveau\", \"Neoclassicism\", \"Rococo\"]', 20, 'A'),
(474, 'Which famous artist is known for creating the sculpture \"David\"?', '[\"Leonardo da Vinci\", \"Michelangelo\", \"Donatello\", \"Raphael\"]', 20, 'B'),
(475, 'Which style of art was characterized by highly stylized, decorative, and intricate details?', '[\"Rococo\", \"Baroque\", \"Cubism\", \"Expressionism\"]', 20, 'A'),
(476, 'Which modern artist is known for his abstract drip paintings?', '[\"Jackson Pollock\", \"Marc Chagall\", \"Henri Matisse\", \"Georgia O’Keeffe\"]', 20, 'A'),
(477, 'Which movement began in the late 19th century and is marked by an emphasis on capturing moments in time?', '[\"Impressionism\", \"Expressionism\", \"Realism\", \"Futurism\"]', 20, 'A'),
(478, 'What is the main characteristic of Realism in art?', '[\"Idealization of subjects\", \"Depiction of everyday life and the working class\", \"Abstract forms\", \"Use of bright, unnatural colors\"]', 20, 'B'),
(479, 'Which famous artist painted \"The Persistence of Memory\"?', '[\"Pablo Picasso\", \"Salvador Dalí\", \"Edvard Munch\", \"Henri Rousseau\"]', 20, 'B'),
(480, 'What is the main subject matter of Fauvism art?', '[\"Realistic portraits\", \"Abstract geometric shapes\", \"Vivid, unnatural colors and landscapes\", \"Classical mythology\"]', 20, 'C'),
(481, 'Which art movement emerged in the early 20th century and was heavily influenced by the growth of modern industrial society?', '[\"Futurism\", \"Realism\", \"Surrealism\", \"Cubism\"]', 20, 'A'),
(482, 'What was the goal of the Arts and Crafts movement?', '[\"To revive traditional craft techniques\", \"To promote industrial mass production\", \"To push for abstract art\", \"To create minimalist designs\"]', 20, 'A'),
(483, 'Who is known as the leader of the Expressionist movement in painting?', '[\"Edvard Munch\", \"Vincent van Gogh\", \"Wassily Kandinsky\", \"Claude Monet\"]', 20, 'A'),
(484, 'Which period of art is defined by the use of perspective and realistic human figures, often seen in works like Leonardo da Vinci’s \"The Last Supper\"?', '[\"Renaissance\", \"Baroque\", \"Impressionism\", \"Cubism\"]', 20, 'A'),
(485, 'What is the recommended number of steps to take daily for good health?', '[\"5,000\", \"7,500\", \"10,000\", \"15,000\"]', 21, 'C'),
(486, 'How long should a person typically warm up before a workout?', '[\"5 minutes\", \"10 minutes\", \"15 minutes\", \"30 minutes\"]', 21, 'B'),
(487, 'Which exercise is best for building leg strength?', '[\"Squats\", \"Push-ups\", \"Planks\", \"Jumping jacks\"]', 21, 'A'),
(488, 'What is the primary muscle worked during a bicep curl?', '[\"Biceps\", \"Triceps\", \"Pectorals\", \"Deltoids\"]', 21, 'A'),
(489, 'Which of these is a cardiovascular exercise?', '[\"Running\", \"Squats\", \"Lunges\", \"Deadlifts\"]', 21, 'A'),
(490, 'How many calories are in one gram of protein?', '[\"3\", \"4\", \"5\", \"9\"]', 21, 'B'),
(491, 'What is the recommended duration of moderate exercise for adults per week?', '[\"60 minutes\", \"90 minutes\", \"150 minutes\", \"200 minutes\"]', 21, 'C'),
(492, 'Which activity is the best for improving flexibility?', '[\"Yoga\", \"Running\", \"Cycling\", \"Swimming\"]', 21, 'A'),
(493, 'What is the main benefit of strength training?', '[\"Building endurance\", \"Building muscle mass\", \"Improving flexibility\", \"Increasing speed\"]', 21, 'B'),
(494, 'What does BMI stand for?', '[\"Body Mass Index\", \"Body Measurement Index\", \"Basic Metabolic Index\", \"Balanced Muscle Indicator\"]', 21, 'A'),
(495, 'Which type of fitness is most important for overall health?', '[\"Cardio\", \"Strength training\", \"Flexibility\", \"Balance\"]', 21, 'A'),
(496, 'What is the primary purpose of a cool-down after exercise?', '[\"To increase heart rate\", \"To relax muscles and reduce stiffness\", \"To increase flexibility\", \"To build strength\"]', 21, 'B'),
(497, 'Which of the following is considered a low-impact exercise?', '[\"Walking\", \"Running\", \"Jumping rope\", \"Burpees\"]', 21, 'A'),
(498, 'Which of the following exercises targets the chest muscles?', '[\"Push-ups\", \"Squats\", \"Planks\", \"Lunges\"]', 21, 'A'),
(499, 'What is the main benefit of aerobic exercise?', '[\"Building muscle\", \"Improving heart health\", \"Increasing flexibility\", \"Strengthening bones\"]', 21, 'B'),
(500, 'What is the purpose of hydration during exercise?', '[\"Increase endurance\", \"Prevent overheating\", \"Support muscle function\", \"All of the above\"]', 21, 'D'),
(501, 'Which type of exercise improves bone density?', '[\"Running\", \"Strength training\", \"Cycling\", \"Yoga\"]', 21, 'B'),
(502, 'Which nutrient is most important for muscle recovery?', '[\"Carbohydrates\", \"Protein\", \"Fats\", \"Vitamins\"]', 21, 'B'),
(503, 'What does HIIT stand for?', '[\"High Intensity Interval Training\", \"Heavy Intensity Interval Training\", \"High Impact Interval Training\", \"Hyper Intensive Interval Training\"]', 21, 'A'),
(504, 'Which of these is a core strengthening exercise?', '[\"Crunches\", \"Running\", \"Cycling\", \"Jumping jacks\"]', 21, 'A'),
(505, 'What is the recommended number of days per week to engage in strength training?', '[\"1-2\", \"2-3\", \"3-4\", \"4-5\"]', 21, 'B'),
(506, 'What is a key component of a successful business strategy?', '[\"Market research\", \"Employee training\", \"Customer loyalty\", \"All of the above\"]', 22, 'D'),
(507, 'Which is NOT a common business growth strategy?', '[\"Market penetration\", \"Market expansion\", \"Price cutting\", \"Community engagement\"]', 22, 'D'),
(508, 'What type of strategy focuses on maintaining leadership in a particular niche?', '[\"Cost leadership\", \"Differentiation\", \"Focus strategy\", \"Growth strategy\"]', 22, 'C'),
(509, 'Which business model involves providing goods or services to the end consumer?', '[\"B2B\", \"B2C\", \"C2C\", \"C2B\"]', 22, 'B'),
(510, 'Which of the following is considered a long-term strategy?', '[\"Increase advertising budget\", \"Increase workforce\", \"Expand into new markets\", \"Adjust pricing\"]', 22, 'C'),
(511, 'What is a key feature of a good business vision?', '[\"Clear financial goals\", \"Focus on short-term gains\", \"Long-term direction\", \"Focus on operational tasks\"]', 22, 'C'),
(512, 'Which method involves analyzing the internal and external factors that can affect a business?', '[\"SWOT analysis\", \"PEST analysis\", \"Five Forces model\", \"Value chain analysis\"]', 22, 'A'),
(513, 'Which of the following is a market penetration strategy?', '[\"Launching a new product\", \"Expanding to new geographic locations\", \"Lowering prices to increase sales\", \"Merging with competitors\"]', 22, 'C'),
(514, 'What is the goal of diversification in business strategy?', '[\"To reduce market risk\", \"To increase customer base\", \"To improve product quality\", \"To improve brand loyalty\"]', 22, 'A'),
(515, 'Which of the following is an example of a cost leadership strategy?', '[\"Offering high-quality luxury products\", \"Expanding into new markets\", \"Providing products at the lowest price\", \"Offering niche products\"]', 22, 'C'),
(516, 'Which of the following is NOT a characteristic of strategic management?', '[\"Goal setting\", \"Continuous evaluation\", \"Short-term focus\", \"Implementation of plans\"]', 22, 'C'),
(517, 'Which term refers to the process of adapting to external changes in the marketplace?', '[\"Business transformation\", \"Market adjustment\", \"Innovation\", \"Market positioning\"]', 22, 'B'),
(518, 'What is the main goal of operational efficiency?', '[\"Improving profitability by reducing costs\", \"Increasing sales through marketing\", \"Enhancing customer experience\", \"Expanding the product line\"]', 22, 'A'),
(519, 'What does B2B stand for in a business context?', '[\"Business to Buyer\", \"Business to Brand\", \"Business to Business\", \"Brand to Business\"]', 22, 'C'),
(520, 'What is an example of a strategic alliance?', '[\"Merger between two companies\", \"Licensing a product to another company\", \"Collaborating with a competitor on research\", \"Acquiring a competitor\"]', 22, 'C'),
(521, 'Which of the following strategies involves offering differentiated products in a market?', '[\"Cost leadership\", \"Differentiation\", \"Focus\", \"Innovation\"]', 22, 'B'),
(522, 'What does a business’s brand equity refer to?', '[\"The value of a business’s brand reputation\", \"The market share of a business\", \"The profitability of a business\", \"The quality of a business’s products\"]', 22, 'A'),
(523, 'Which of the following is a feature of a SWOT analysis?', '[\"Market trends\", \"Company weaknesses\", \"Competitor strategies\", \"Employee satisfaction\"]', 22, 'B'),
(524, 'What is the first step in the strategic management process?', '[\"Formulating a plan\", \"Evaluating the external environment\", \"Setting objectives\", \"Implementing strategy\"]', 22, 'C'),
(525, 'What is the role of a business consultant?', '[\"To manage a business’s daily operations\", \"To provide external advice and solutions\", \"To handle customer relations\", \"To design products\"]', 22, 'B'),
(526, 'When did the American Civil War begin?', '[\"1776\", \"1861\", \"1914\", \"1945\"]', 23, 'B'),
(527, 'In which year did World War I start?', '[\"1912\", \"1914\", \"1916\", \"1918\"]', 23, 'B'),
(528, 'When was the Declaration of Independence signed?', '[\"1776\", \"1787\", \"1791\", \"1800\"]', 23, 'A'),
(529, 'Which year did the Titanic sink?', '[\"1900\", \"1910\", \"1912\", \"1920\"]', 23, 'C'),
(530, 'What year did the Berlin Wall fall?', '[\"1987\", \"1989\", \"1991\", \"1993\"]', 23, 'B'),
(531, 'When did the first man land on the moon?', '[\"1965\", \"1969\", \"1971\", \"1973\"]', 23, 'B'),
(532, 'In what year did the French Revolution begin?', '[\"1775\", \"1789\", \"1795\", \"1800\"]', 23, 'B'),
(533, 'When did the United States enter World War II?', '[\"1939\", \"1941\", \"1943\", \"1945\"]', 23, 'B'),
(534, 'Which year did India gain independence from Britain?', '[\"1947\", \"1950\", \"1960\", \"1970\"]', 23, 'A'),
(535, 'What year was the United Nations founded?', '[\"1943\", \"1945\", \"1950\", \"1955\"]', 23, 'B'),
(536, 'When was the Magna Carta signed?', '[\"1100\", \"1215\", \"1300\", \"1400\"]', 23, 'B'),
(537, 'When was the assassination of Archduke Franz Ferdinand?', '[\"1912\", \"1914\", \"1916\", \"1918\"]', 23, 'B'),
(538, 'What year did Christopher Columbus arrive in the Americas?', '[\"1492\", \"1500\", \"1600\", \"1700\"]', 23, 'A'),
(539, 'When did the Great Depression begin?', '[\"1927\", \"1929\", \"1933\", \"1936\"]', 23, 'B'),
(540, 'In which year did Japan attack Pearl Harbor?', '[\"1938\", \"1941\", \"1945\", \"1949\"]', 23, 'B'),
(541, 'What year was the first successful flight by the Wright brothers?', '[\"1900\", \"1901\", \"1903\", \"1905\"]', 23, 'C'),
(542, 'In what year did the Cold War end?', '[\"1987\", \"1991\", \"1995\", \"2000\"]', 23, 'B'),
(543, 'What year did the Roman Empire fall?', '[\"476 AD\", \"600 AD\", \"800 AD\", \"1000 AD\"]', 23, 'A'),
(544, 'When was the Treaty of Versailles signed?', '[\"1917\", \"1919\", \"1920\", \"1922\"]', 23, 'B'),
(545, 'In which year did the Battle of Hastings take place?', '[\"1066\", \"1080\", \"1100\", \"1200\"]', 23, 'A'),
(546, 'What is the purpose of a thesis statement in academic writing?', '[\"To summarize the conclusion\", \"To introduce the topic\", \"To present the main argument\", \"To cite sources\"]', 24, 'C'),
(547, 'What is a topic sentence?', '[\"A sentence that concludes the paragraph\", \"A sentence that introduces the main idea of a paragraph\", \"A sentence that summarizes the article\", \"A sentence that defines the thesis\"]', 24, 'B'),
(548, 'Which of the following is an example of formal academic language?', '[\"Hey, guys!\", \"The data suggests that...\", \"We need more fun!\", \"I think the result is okay.\"]', 24, 'B'),
(549, 'What does \"plagiarism\" mean?', '[\"Quoting a source\", \"Citing a source\", \"Copying someone else’s work without credit\", \"Paraphrasing\"]', 24, 'C'),
(550, 'Which is the correct way to cite a book in APA format?', '[\"Smith, J. (2001). Title of book. Publisher.\", \"Smith, J. Title of book. 2001. Publisher.\", \"Smith, Title of book. 2001. Publisher.\", \"Smith, J. (Title of book. Publisher. 2001)\"]', 24, 'A'),
(551, 'Which of the following is an appropriate academic writing style?', '[\"Using contractions\", \"Writing in a conversational tone\", \"Using complex sentences and formal vocabulary\", \"Expressing personal opinions\"]', 24, 'C'),
(552, 'What is the purpose of an abstract in a research paper?', '[\"To provide a summary of the main points of the paper\", \"To discuss the limitations of the study\", \"To present the conclusion in detail\", \"To list the sources used\"]', 24, 'A'),
(553, 'What should you do if you paraphrase information from a source?', '[\"Rewrite it exactly as it appears\", \"Cite the source\", \"Include a personal opinion\", \"Quote it directly\"]', 24, 'B'),
(554, 'Which of the following is NOT a key part of academic writing?', '[\"Clear organization\", \"Complex vocabulary\", \"Objective tone\", \"Personal anecdotes\"]', 24, 'D'),
(555, 'What does it mean to \"synthesize\" information?', '[\"To copy information from sources\", \"To combine information from multiple sources into a cohesive argument\", \"To summarize a source\", \"To analyze information in isolation\"]', 24, 'B'),
(556, 'In academic writing, what is the role of evidence?', '[\"To support the argument\", \"To summarize the topic\", \"To confuse the reader\", \"To provide personal opinions\"]', 24, 'A'),
(557, 'What is the purpose of a conclusion in an academic paper?', '[\"To restate the thesis and summarize the key points\", \"To introduce new information\", \"To provide background information\", \"To quote sources\"]', 24, 'A'),
(558, 'Which sentence is most appropriate for an academic essay introduction?', '[\"So, let’s discuss this important topic.\", \"In this paper, I will explain the causes of global warming.\", \"This topic is something that people often argue about.\", \"I think global warming is bad.\"]', 24, 'B'),
(559, 'What is the difference between a primary and secondary source?', '[\"Primary sources are direct evidence, while secondary sources analyze or interpret primary sources\", \"Primary sources are less reliable than secondary sources\", \"Primary sources are older than secondary sources\", \"Secondary sources are always books, while primary sources are journal articles\"]', 24, 'A'),
(560, 'Which of the following is an example of a primary source?', '[\"A research article summarizing a study\", \"A newspaper article about an event\", \"A letter written during World War II\", \"A history book about World War II\"]', 24, 'C'),
(561, 'What is a common mistake in academic writing?', '[\"Overuse of direct quotations\", \"Paraphrasing without citing\", \"Using formal tone\", \"Including an introduction\"]', 24, 'B'),
(562, 'What should an academic writer do to avoid biased language?', '[\"Use gender-neutral terms\", \"Include personal opinions\", \"Use informal language\", \"Avoid using evidence\"]', 24, 'A'),
(563, 'How can a writer improve the clarity of their argument?', '[\"By adding more complex vocabulary\", \"By including more quotes\", \"By organizing ideas logically\", \"By using informal language\"]', 24, 'C'),
(564, 'Which of the following is a good practice when writing a literature review?', '[\"Criticizing the authors of the sources\", \"Summarizing all sources equally\", \"Organizing sources thematically\", \"Only using books as sources\"]', 24, 'C');
INSERT INTO `questions` (`id`, `question_text`, `options`, `quiz_id`, `correct_answer`) VALUES
(565, 'Who wrote \"1984\"?', '[\"George Orwell\", \"Aldous Huxley\", \"J.K. Rowling\", \"Ernest Hemingway\"]', 25, 'A'),
(566, 'Which novel is considered Jane Austen’s most famous work?', '[\"Pride and Prejudice\", \"Emma\", \"Mansfield Park\", \"Sense and Sensibility\"]', 25, 'A'),
(567, 'Who is the author of \"The Great Gatsby\"?', '[\"F. Scott Fitzgerald\", \"Ernest Hemingway\", \"John Steinbeck\", \"Mark Twain\"]', 25, 'A'),
(568, 'Which book begins with the line \"Call me Ishmael\"?', '[\"Moby-Dick\", \"The Catcher in the Rye\", \"To Kill a Mockingbird\", \"Great Expectations\"]', 25, 'A'),
(569, 'Who wrote \"Harry Potter and the Sorcerer’s Stone\"?', '[\"J.K. Rowling\", \"C.S. Lewis\", \"J.R.R. Tolkien\", \"Philip Pullman\"]', 25, 'A'),
(570, 'Which book was written by Charles Dickens?', '[\"Pride and Prejudice\", \"1984\", \"Oliver Twist\", \"Frankenstein\"]', 25, 'C'),
(571, 'Who wrote \"The Catcher in the Rye\"?', '[\"J.D. Salinger\", \"Harper Lee\", \"Mark Twain\", \"George Orwell\"]', 25, 'A'),
(572, 'Who wrote \"The Lord of the Rings\"?', '[\"C.S. Lewis\", \"George Orwell\", \"J.R.R. Tolkien\", \"J.K. Rowling\"]', 25, 'C'),
(573, 'Which novel is set in the fictional country of Gilead?', '[\"The Handmaid’s Tale\", \"The Bell Jar\", \"Brave New World\", \"The Hunger Games\"]', 25, 'A'),
(574, 'Who is the author of \"To Kill a Mockingbird\"?', '[\"Harper Lee\", \"J.D. Salinger\", \"Mark Twain\", \"William Faulkner\"]', 25, 'A'),
(575, 'Which of the following novels was written by George Orwell?', '[\"Brave New World\", \"1984\", \"The Catcher in the Rye\", \"The Grapes of Wrath\"]', 25, 'B'),
(576, 'Which book was written by William Golding?', '[\"Lord of the Flies\", \"The Outsiders\", \"The Great Gatsby\", \"Of Mice and Men\"]', 25, 'A'),
(577, 'Who wrote \"The Hobbit\"?', '[\"C.S. Lewis\", \"J.R.R. Tolkien\", \"J.K. Rowling\", \"Terry Pratchett\"]', 25, 'B'),
(578, 'Which of the following books was written by F. Scott Fitzgerald?', '[\"The Great Gatsby\", \"The Grapes of Wrath\", \"Of Mice and Men\", \"The Sun Also Rises\"]', 25, 'A'),
(579, 'Who is the author of \"Brave New World\"?', '[\"Aldous Huxley\", \"Ray Bradbury\", \"Philip K. Dick\", \"Margaret Atwood\"]', 25, 'A'),
(580, 'Which classic novel was written by Mary Shelley?', '[\"Frankenstein\", \"Dracula\", \"The Strange Case of Dr Jekyll and Mr Hyde\", \"Pride and Prejudice\"]', 25, 'A'),
(581, 'Who wrote \"Crime and Punishment\"?', '[\"Fyodor Dostoevsky\", \"Leo Tolstoy\", \"Anton Chekhov\", \"Ivan Turgenev\"]', 25, 'A'),
(582, 'Which book was written by J.R.R. Tolkien besides \"The Lord of the Rings\"?', '[\"The Hobbit\", \"The Silmarillion\", \"The Chronicles of Narnia\", \"The Dark Tower\"]', 25, 'A'),
(583, 'Who is the author of \"Wuthering Heights\"?', '[\"Charlotte Brontë\", \"Emily Brontë\", \"Jane Austen\", \"Mary Shelley\"]', 25, 'B'),
(584, 'Which author wrote the \"Narnia\" series?', '[\"J.R.R. Tolkien\", \"C.S. Lewis\", \"Terry Pratchett\", \"Philip Pullman\"]', 25, 'B'),
(585, 'Who won the Oscar for Best Actor in 2023?', '[\"Brendan Fraser\", \"Austin Butler\", \"Tom Cruise\", \"Will Smith\"]', 26, 'A'),
(586, 'Which movie won the Oscar for Best Picture in 2022?', '[\"The Power of the Dog\", \"Dune\", \"CODA\", \"West Side Story\"]', 26, 'C'),
(587, 'Who played the role of Iron Man in the Marvel Cinematic Universe?', '[\"Chris Hemsworth\", \"Robert Downey Jr.\", \"Chris Evans\", \"Mark Ruffalo\"]', 26, 'B'),
(588, 'Which singer is known as the \"Queen of Pop\"?', '[\"Madonna\", \"Beyoncé\", \"Lady Gaga\", \"Ariana Grande\"]', 26, 'A'),
(589, 'Who directed \"Inception\"?', '[\"Steven Spielberg\", \"Christopher Nolan\", \"Quentin Tarantino\", \"Martin Scorsese\"]', 26, 'B'),
(590, 'Which of these actors starred in the \"Pirates of the Caribbean\" series?', '[\"Johnny Depp\", \"Orlando Bloom\", \"Brad Pitt\", \"Tom Cruise\"]', 26, 'A'),
(591, 'Which movie is the highest-grossing film of all time (as of 2023)?', '[\"Avatar\", \"Avengers: Endgame\", \"Titanic\", \"Star Wars: The Force Awakens\"]', 26, 'B'),
(592, 'Which actor played the role of the Joker in \"The Dark Knight\"?', '[\"Heath Ledger\", \"Jared Leto\", \"Jack Nicholson\", \"Joaquin Phoenix\"]', 26, 'A'),
(593, 'Who is known for singing \"Rolling in the Deep\"?', '[\"Adele\", \"Beyoncé\", \"Lady Gaga\", \"Shakira\"]', 26, 'A'),
(594, 'What year did the first \"Star Wars\" movie release?', '[\"1977\", \"1980\", \"1975\", \"1983\"]', 26, 'A'),
(595, 'Which music video became the most-viewed on YouTube in 2020?', '[\"Despacito\", \"Baby Shark\", \"Shape of You\", \"Uptown Funk\"]', 26, 'B'),
(596, 'Who won the Grammy Award for Album of the Year in 2022?', '[\"Olivia Rodrigo\", \"Beyoncé\", \"Billie Eilish\", \"Taylor Swift\"]', 26, 'A'),
(597, 'Who played the role of Jack Dawson in \"Titanic\"?', '[\"Johnny Depp\", \"Matt Damon\", \"Leonardo DiCaprio\", \"Brad Pitt\"]', 26, 'C'),
(598, 'Which TV series is known for the phrase \"Winter is Coming\"?', '[\"Breaking Bad\", \"Game of Thrones\", \"Stranger Things\", \"The Crown\"]', 26, 'B'),
(599, 'Who starred as the \"Black Panther\" in the Marvel Cinematic Universe?', '[\"Chadwick Boseman\", \"Michael B. Jordan\", \"Chris Hemsworth\", \"Samuel L. Jackson\"]', 26, 'A'),
(600, 'Which actor played Tony Stark/Iron Man in the MCU?', '[\"Chris Hemsworth\", \"Robert Downey Jr.\", \"Chris Evans\", \"Mark Ruffalo\"]', 26, 'B'),
(601, 'Which animated film won the Oscar for Best Animated Feature in 2021?', '[\"Soul\", \"Frozen II\", \"The Croods: A New Age\", \"Onward\"]', 26, 'A'),
(602, 'Which singer is known as the \"King of Pop\"?', '[\"Michael Jackson\", \"Elvis Presley\", \"Justin Timberlake\", \"Prince\"]', 26, 'A'),
(603, 'What was the first feature-length animated film?', '[\"Snow White and the Seven Dwarfs\", \"Cinderella\", \"Pinocchio\", \"Bambi\"]', 26, 'A'),
(604, 'Which popular series of books was adapted into a TV series called \"The Witcher\"?', '[\"A Song of Ice and Fire\", \"The Lord of the Rings\", \"The Witcher\", \"Percy Jackson\"]', 26, 'C'),
(605, 'What is the capital of France?', '[\"Paris\", \"Berlin\", \"Madrid\", \"Rome\"]', 27, 'A'),
(606, 'Which planet is known as the Red Planet?', '[\"Mars\", \"Venus\", \"Jupiter\", \"Saturn\"]', 27, 'A'),
(607, 'Who wrote \"Romeo and Juliet\"?', '[\"William Shakespeare\", \"Charles Dickens\", \"Jane Austen\", \"Leo Tolstoy\"]', 27, 'A'),
(608, 'What is the smallest continent by land area?', '[\"Australia\", \"Antarctica\", \"Europe\", \"South America\"]', 27, 'A'),
(609, 'Which ocean is the largest?', '[\"Pacific Ocean\", \"Atlantic Ocean\", \"Indian Ocean\", \"Arctic Ocean\"]', 27, 'A'),
(610, 'What year did World War II end?', '[\"1945\", \"1918\", \"1939\", \"1965\"]', 27, 'A'),
(611, 'Who invented the telephone?', '[\"Alexander Graham Bell\", \"Thomas Edison\", \"Nikola Tesla\", \"Isaac Newton\"]', 27, 'A'),
(612, 'Which country is the largest by land area?', '[\"Russia\", \"Canada\", \"United States\", \"China\"]', 27, 'A'),
(613, 'In which year did man land on the moon?', '[\"1969\", \"1965\", \"1972\", \"1959\"]', 27, 'A'),
(614, 'Which artist painted the Mona Lisa?', '[\"Leonardo da Vinci\", \"Vincent van Gogh\", \"Pablo Picasso\", \"Claude Monet\"]', 27, 'A'),
(615, 'What is the chemical symbol for water?', '[\"H2O\", \"O2\", \"CO2\", \"H2\"]', 27, 'A'),
(616, 'Which country is known as the Land of the Rising Sun?', '[\"Japan\", \"China\", \"India\", \"South Korea\"]', 27, 'A'),
(617, 'What is the currency of the United Kingdom?', '[\"Pound Sterling\", \"Euro\", \"Yen\", \"Dollar\"]', 27, 'A'),
(618, 'Which element has the chemical symbol \"O\"?', '[\"Oxygen\", \"Osmium\", \"Oganesson\", \"Ozone\"]', 27, 'A'),
(619, 'Who painted the Sistine Chapel ceiling?', '[\"Michelangelo\", \"Leonardo da Vinci\", \"Raphael\", \"Donatello\"]', 27, 'A'),
(620, 'What is the largest animal on Earth?', '[\"Blue Whale\", \"African Elephant\", \"Giraffe\", \"Shark\"]', 27, 'A'),
(621, 'Which city is known as the Big Apple?', '[\"New York City\", \"Los Angeles\", \"Chicago\", \"San Francisco\"]', 27, 'A'),
(622, 'What is the hardest natural substance on Earth?', '[\"Diamond\", \"Gold\", \"Iron\", \"Platinum\"]', 27, 'A'),
(623, 'What is the largest desert in the world?', '[\"Sahara Desert\", \"Gobi Desert\", \"Karakum Desert\", \"Atacama Desert\"]', 27, 'A'),
(624, 'What is the most spoken language in the world?', '[\"Mandarin\", \"English\", \"Spanish\", \"Hindi\"]', 27, 'A');

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`id`, `name`, `category_id`) VALUES
(2, 'Today News', 78),
(3, 'Media Stars', 87),
(5, 'English Lite', 82),
(6, 'Indian History', 85),
(7, 'World Capitals Quiz', 85),
(8, 'Basic Algebra Problems', 80),
(9, 'Modern Science Breakthroughs', 79),
(10, 'Oscar Winners Trivia', 81),
(11, 'Classic Literature Authors', 82),
(12, 'Famous Sports Personalities', 83),
(13, 'Economic Concepts Explained', 84),
(14, 'Geography of Europe', 85),
(15, 'Grammar and Vocabulary Test', 82),
(16, 'Technology in the 21st Century', 79),
(17, 'Pop Culture Icons of the 2000s', 87),
(18, 'Global Current Affairs', 78),
(19, 'Beginner’s Math Challenge', 80),
(20, 'Art Movements Through History', 81),
(21, 'Physical Fitness Fundamentals', 83),
(22, 'Business Strategies Quiz', 84),
(23, 'Historical Events Timeline', 85),
(24, 'Academic Writing Skills', 86),
(25, 'Famous Books and Authors', 82),
(26, 'Entertainment Industry Facts', 87),
(27, 'General Knowledge Challenge', 78),
(28, 'Space Exploration Advances', 79),
(29, 'Logical Reasoning Problems', 80),
(30, 'Music History Quiz', 81),
(31, 'Sports World Championships', 83),
(32, 'Famous Historical Figures', 85),
(33, 'Advanced Calculus Problems', 80),
(34, 'Artificial Intelligence Trends', 79),
(35, 'Hollywood Blockbusters Trivia', 81),
(36, 'Shakespearean Plays Quiz', 82),
(37, 'Olympic Games History', 83),
(38, 'Principles of Marketing', 84),
(39, 'Landmarks Around the World', 85),
(40, 'Education Theories and Practices', 86),
(41, 'Iconic TV Shows of the 90s', 87);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_attempts`
--

CREATE TABLE `quiz_attempts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `completed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_attempts`
--

INSERT INTO `quiz_attempts` (`id`, `user_id`, `quiz_id`, `score`, `completed_at`) VALUES
(12, 3, 2, 20, '2024-12-06 10:52:35'),
(17, 1, 3, 14, '2024-12-06 14:11:30'),
(21, 20, 8, 0, '2024-12-07 15:13:11'),
(22, 20, 19, 0, '2024-12-07 16:59:09'),
(23, 20, 19, 0, '2024-12-07 17:22:34'),
(24, 20, 10, 0, '2024-12-07 17:24:09'),
(25, 20, 2, 0, '2024-12-07 17:26:41'),
(26, 20, 2, 2, '2024-12-07 17:38:12'),
(27, 20, 2, 0, '2024-12-07 17:41:06'),
(28, 20, 2, 1, '2024-12-07 17:41:44');

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `score` int(11) NOT NULL,
  `attempt_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  `pass_reset_token` varchar(255) DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `is_admin`, `pass_reset_token`, `reset_expires`, `created_at`) VALUES
(1, 'Akshay', '$2y$10$tIJZ62aiM/a0I8hEEv4gH.btLcyy1.KCckXQY/DDMqjg4qpdLkv0O', 'akshaykomade012345@gmail.com', 1, NULL, NULL, '2024-11-28 13:00:53'),
(2, 'yash', '$2y$10$tIJZ62aiM/a0I8hEEv4gH.btLcyy1.KCckXQY/DDMqjg4qpdLkv0O', 'lonewolfcoc08@gmail.com', 0, NULL, NULL, '2024-11-28 13:00:53'),
(3, 'Akshay', '$2y$10$tIJZ62aiM/a0I8hEEv4gH.btLcyy1.KCckXQY/DDMqjg4qpdLkv0O', 'komaleakshay@gmail.com', 0, NULL, NULL, '2024-11-28 13:00:53'),
(4, 'yash', '$2y$10$tIJZ62aiM/a0I8hEEv4gH.btLcyy1.KCckXQY/DDMqjg4qpdLkv0O', 'yash@gmail.com', 0, NULL, NULL, '2024-11-28 13:00:53'),
(5, 'test', '$2y$10$tIJZ62aiM/a0I8hEEv4gH.btLcyy1.KCckXQY/DDMqjg4qpdLkv0O', 'test@gmail.com', 0, NULL, NULL, '2024-11-28 13:00:53'),
(7, 'Akshay Komale', '$2y$10$tIJZ62aiM/a0I8hEEv4gH.btLcyy1.KCckXQY/DDMqjg4qpdLkv0O', 'akshay@gmail.com', 0, NULL, NULL, '2024-12-06 08:04:47'),
(8, 'john_doe', '$2y$10$tIJZ62aiM/a0I8hEEv4gH.btLcyy1.KCckXQY/DDMqjg4qpdLkv0O', 'john.doe@example.com', 0, NULL, NULL, '2024-12-07 14:19:17'),
(9, 'jane_smith', '$2y$10$tIJZ62aiM/a0I8hEEv4gH.btLcyy1.KCckXQY/DDMqjg4qpdLkv0O', 'jane.smith@example.com', 0, NULL, NULL, '2024-12-07 14:19:17'),
(10, 'alex_jones', '$2y$10$tIJZ62aiM/a0I8hEEv4gH.btLcyy1.KCckXQY/DDMqjg4qpdLkv0O', 'alex.jones@example.com', 0, NULL, NULL, '2024-12-07 14:19:17'),
(11, 'emily_clark', '$2y$10$tIJZ62aiM/a0I8hEEv4gH.btLcyy1.KCckXQY/DDMqjg4qpdLkv0O', 'emily.clark@example.com', 0, NULL, NULL, '2024-12-07 14:19:17'),
(12, 'michael_brown', '$2y$10$tIJZ62aiM/a0I8hEEv4gH.btLcyy1.KCckXQY/DDMqjg4qpdLkv0O', 'michael.brown@example.com', 0, NULL, NULL, '2024-12-07 14:19:17'),
(13, 'sarah_davis', '$2y$10$tIJZ62aiM/a0I8hEEv4gH.btLcyy1.KCckXQY/DDMqjg4qpdLkv0O', 'sarah.davis@example.com', 0, NULL, NULL, '2024-12-07 14:19:17'),
(14, 'david_miller', '$2y$10$tIJZ62aiM/a0I8hEEv4gH.btLcyy1.KCckXQY/DDMqjg4qpdLkv0O', 'david.miller@example.com', 0, NULL, NULL, '2024-12-07 14:19:17'),
(15, 'laura_wilson', '$2y$10$tIJZ62aiM/a0I8hEEv4gH.btLcyy1.KCckXQY/DDMqjg4qpdLkv0O', 'laura.wilson@example.com', 0, NULL, NULL, '2024-12-07 14:19:17'),
(16, 'daniel_moore', '$2y$10$tIJZ62aiM/a0I8hEEv4gH.btLcyy1.KCckXQY/DDMqjg4qpdLkv0O', 'daniel.moore@example.com', 0, NULL, NULL, '2024-12-07 14:19:17'),
(17, 'emma_taylor', '$2y$10$tIJZ62aiM/a0I8hEEv4gH.btLcyy1.KCckXQY/DDMqjg4qpdLkv0O', 'emma.taylor@example.com', 0, NULL, NULL, '2024-12-07 14:19:17'),
(18, 'william_anderson', '$2y$10$tIJZ62aiM/a0I8hEEv4gH.btLcyy1.KCckXQY/DDMqjg4qpdLkv0O', 'william.anderson@example.com', 0, NULL, NULL, '2024-12-07 14:19:17'),
(19, 'olivia_thomas', '$2y$10$tIJZ62aiM/a0I8hEEv4gH.btLcyy1.KCckXQY/DDMqjg4qpdLkv0O', 'olivia.thomas@example.com', 0, NULL, NULL, '2024-12-07 14:19:17'),
(20, 'James', '$2y$10$tIJZ62aiM/a0I8hEEv4gH.btLcyy1.KCckXQY/DDMqjg4qpdLkv0O', 'james.jackson@example.com', 0, NULL, NULL, '2024-12-07 14:19:17'),
(21, 'sophia_white', '$2y$10$tIJZ62aiM/a0I8hEEv4gH.btLcyy1.KCckXQY/DDMqjg4qpdLkv0O', 'sophia.white@example.com', 0, NULL, NULL, '2024-12-07 14:19:17'),
(22, 'benjamin_harris', '$2y$10$tIJZ62aiM/a0I8hEEv4gH.btLcyy1.KCckXQY/DDMqjg4qpdLkv0O', 'benjamin.harris@example.com', 0, NULL, NULL, '2024-12-07 14:19:17'),
(23, 'chloe_martin', '$2y$10$tIJZ62aiM/a0I8hEEv4gH.btLcyy1.KCckXQY/DDMqjg4qpdLkv0O', 'chloe.martin@example.com', 0, NULL, NULL, '2024-12-07 14:19:17'),
(24, 'henry_lee', '$2y$10$tIJZ62aiM/a0I8hEEv4gH.btLcyy1.KCckXQY/DDMqjg4qpdLkv0O', 'henry.lee@example.com', 0, NULL, NULL, '2024-12-07 14:19:17'),
(25, 'mia_perez', '$2y$10$tIJZ62aiM/a0I8hEEv4gH.btLcyy1.KCckXQY/DDMqjg4qpdLkv0O', 'mia.perez@example.com', 0, NULL, NULL, '2024-12-07 14:19:17'),
(26, 'jacob_clark', '$2y$10$tIJZ62aiM/a0I8hEEv4gH.btLcyy1.KCckXQY/DDMqjg4qpdLkv0O', 'jacob.clark@example.com', 0, NULL, NULL, '2024-12-07 14:19:17'),
(27, 'ella_lopez', '$2y$10$tIJZ62aiM/a0I8hEEv4gH.btLcyy1.KCckXQY/DDMqjg4qpdLkv0O', 'ella.lopez@example.com', 0, NULL, NULL, '2024-12-07 14:19:17'),
(28, 'ethan_roberts', '$2y$10$tIJZ62aiM/a0I8hEEv4gH.btLcyy1.KCckXQY/DDMqjg4qpdLkv0O', 'ethan.roberts@example.com', 0, NULL, NULL, '2024-12-07 14:19:17'),
(29, 'amelia_gonzalez', '$2y$10$tIJZ62aiM/a0I8hEEv4gH.btLcyy1.KCckXQY/DDMqjg4qpdLkv0O', 'amelia.gonzalez@example.com', 0, NULL, NULL, '2024-12-07 14:19:17'),
(30, 'noah_hall', '$2y$10$tIJZ62aiM/a0I8hEEv4gH.btLcyy1.KCckXQY/DDMqjg4qpdLkv0O', 'noah.hall@example.com', 0, NULL, NULL, '2024-12-07 14:19:17'),
(31, 'isabella_lewis', '$2y$10$tIJZ62aiM/a0I8hEEv4gH.btLcyy1.KCckXQY/DDMqjg4qpdLkv0O', 'isabella.lewis@example.com', 0, NULL, NULL, '2024-12-07 14:19:17'),
(32, 'logan_hill', '$2y$10$tIJZ62aiM/a0I8hEEv4gH.btLcyy1.KCckXQY/DDMqjg4qpdLkv0O', 'logan.hill@example.com', 0, NULL, NULL, '2024-12-07 14:19:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_que_1` (`quiz_id`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_quiz_1` (`category_id`);

--
-- Indexes for table `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_quizat_1` (`quiz_id`),
  ADD KEY `fk_quizat_2` (`user_id`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=625;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `fk_que_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`);

--
-- Constraints for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD CONSTRAINT `fk_quiz_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  ADD CONSTRAINT `fk_quizat_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `quiz_attempts` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`);

--
-- Constraints for table `results`
--
ALTER TABLE `results`
  ADD CONSTRAINT `results_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
