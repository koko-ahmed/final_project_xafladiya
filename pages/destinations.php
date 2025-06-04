<?php
$city = isset($_GET['city']) ? htmlspecialchars($_GET['city']) : 'Unknown';
$cityKey = strtolower($city);
// City-specific images (add more as needed)
$cityImages = [
    'mogadishu' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=900&q=80',
    'hargeisa' => 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?auto=format&fit=crop&w=900&q=80',
    'garowe' => 'https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?auto=format&fit=crop&w=900&q=80',
    'bosaso' => 'https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=900&q=80',
];
$img = $cityImages[$cityKey] ?? 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=900&q=80';
// City display names for navbar consistency
$cityNames = [
    'mogadishu' => 'Mogadishu',
    'hargeisa' => 'Hargeisa',
    'garowe' => 'Garowe',
    'bosaso' => 'Bosaso',
];
$cityDisplay = $cityNames[$cityKey] ?? ucfirst($city);
// City-specific info (placeholder for now)
$cityInfo = [
    'mogadishu' => [
        'history' => 'Mogadishu, the capital of Somalia, has a rich history as a major port and trading center on the Indian Ocean. It has been influenced by Arab, Persian, and African cultures for centuries.',
        'attractions' => ['Liido Beach', 'The Old Harbor', 'Mogadishu Cathedral', 'National Museum of Somalia'],
        'funfact' => 'Mogadishu is sometimes called the "White Pearl of the Indian Ocean" due to its beautiful beaches and white-washed buildings.'
    ],
    'hargeisa' => [
        'history' => 'Hargeisa is the capital of Somaliland and is known for its vibrant markets and unique rock art sites. It has grown rapidly in recent decades.',
        'attractions' => ['Laas Geel cave paintings', 'Independence Monument', 'Hargeisa War Memorial', 'Livestock Market'],
        'funfact' => 'Laas Geel, near Hargeisa, contains some of the oldest and best-preserved rock art in Africa.'
    ],
    'garowe' => [
        'history' => 'Garowe is the administrative capital of Puntland, Somalia. It is a growing city known for its educational institutions and government buildings.',
        'attractions' => ['Puntland State University', 'Garowe International Airport', 'Local markets'],
        'funfact' => 'Garowe is a hub for education and governance in northeastern Somalia.'
    ],
    'bosaso' => [
        'history' => 'Bosaso is a major port city on the Gulf of Aden and a commercial center for Puntland. It has a diverse population and a bustling port.',
        'attractions' => ['Bosaso Port', 'Biyo Kulule hot springs', 'Golis Mountains'],
        'funfact' => 'Bosaso is known as the "Gateway to Somalia" due to its strategic port location.'
    ],
];
$info = $cityInfo[$cityKey] ?? [
    'history' => 'This city has a unique history and culture. More information will be added soon.',
    'attractions' => ['Main Square', 'Central Market', 'Famous Park'],
    'funfact' => 'Every city has its own charm and hidden gems!'
];
// Gallery images
$gallery = [];
for ($i = 1; $i <= 5; $i++) {
    $gallery[] = "https://source.unsplash.com/600x400/?{$cityDisplay},landmark&sig={$i}";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Destination: <?php echo $cityDisplay; ?></title>
    <link rel="stylesheet" href="../assets/css/hero.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .destination-hero {
            position: relative;
            min-height: 340px;
            background: url('<?php echo $img; ?>') center center/cover no-repeat;
            display: flex;
            align-items: flex-end;
            border-radius: 0 0 2rem 2rem;
            overflow: hidden;
        }
        .destination-hero::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(135deg, rgba(30,30,60,0.5) 0%, rgba(0,0,0,0.3) 100%);
            z-index: 1;
        }
        .destination-info {
            position: relative;
            z-index: 2;
            background: rgba(255,255,255,0.18);
            backdrop-filter: blur(12px);
            border-radius: 1.5rem 1.5rem 0 0;
            margin: 0 2rem 2rem 2rem;
            padding: 2rem 2.5rem 1.5rem 2.5rem;
            box-shadow: 0 8px 32px rgba(30, 60, 90, 0.12);
            color: #fff;
            max-width: 600px;
        }
        .destination-info h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: #fff;
            text-shadow: 0 2px 8px rgba(30,60,90,0.18);
        }
        .destination-info h2 {
            font-size: 1.3rem;
            font-weight: 400;
            margin-bottom: 1rem;
            color: #e0e0e0;
        }
        .destination-info p {
            font-size: 1.1rem;
            color: #f3f3f3;
            margin-bottom: 1.5rem;
        }
        .btn-glass {
            background: rgba(255,255,255,0.18);
            color: #fff;
            border: 2px solid #fff;
            border-radius: 2rem;
            transition: background 0.2s, color 0.2s;
            box-shadow: 0 2px 8px rgba(30,60,90,0.10);
        }
        .btn-glass:hover, .btn-glass:focus {
            background: #fff;
            color: #1976d2;
            border-color: #fff;
        }
        .city-details-section {
            background: #fff;
            border-radius: 1.5rem;
            box-shadow: 0 4px 24px rgba(30,60,90,0.08);
            margin: 2rem auto;
            padding: 2rem 2.5rem;
            max-width: 800px;
        }
        .city-details-section h3 {
            color: #1976d2;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        .city-details-section ul {
            padding-left: 1.2rem;
        }
        .city-details-section li {
            margin-bottom: 0.5rem;
        }
        .city-details-section .fun-fact {
            background: rgba(25, 118, 210, 0.08);
            border-left: 4px solid #1976d2;
            padding: 1rem 1.2rem;
            border-radius: 0.75rem;
            margin-top: 1.5rem;
            color: #1976d2;
            font-style: italic;
        }
        .gallery-section {
            max-width: 1100px;
            margin: 2rem auto 3rem auto;
        }
        .gallery-title {
            color: #1976d2;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
        }
        .gallery-img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-radius: 1.2rem;
            box-shadow: 0 4px 16px rgba(30,60,90,0.10);
            transition: transform 0.4s, box-shadow 0.3s;
        }
        .gallery-img:hover {
            transform: scale(1.05) translateY(-6px);
            box-shadow: 0 8px 32px rgba(30,60,90,0.18);
        }
        @media (max-width: 991.98px) {
            .destination-info {
                margin: 0 0.5rem 1rem 0.5rem;
                padding: 1.2rem 1rem 1rem 1rem;
            }
            .city-details-section {
                padding: 1.2rem 1rem;
            }
        }
        @media (max-width: 767.98px) {
            .destination-hero {
                min-height: 180px;
            }
            .destination-info h1 {
                font-size: 1.5rem;
            }
            .gallery-img {
                height: 140px;
            }
        }
    </style>
</head>
<body style="background: #f8fafc;">
    <div class="destination-hero">
        <div class="destination-info">
            <h1><?php echo $cityDisplay; ?></h1>
            <h2>Welcome to <?php echo $cityDisplay; ?>!</h2>
            <p>Discover the beauty, culture, and unique experiences that <?php echo $cityDisplay; ?> has to offer. This is a modern, scenic destination page. Add highlights, things to do, or more info here!</p>
            <a href="../index.php" class="btn btn-glass">Back to Home</a>
        </div>
    </div>
</body>
</html> 