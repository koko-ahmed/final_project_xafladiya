<?php
require_once '../config/config.php';
$page_title = 'All Cities - ' . $site_name;
include '../includes/header.php';

$cities = [
    [
        'name' => 'Mogadishu',
        'image' => 'https://images.pexels.com/photos/417074/pexels-photo-417074.jpeg?auto=compress&cs=tinysrgb&w=800',
        'url' => '/city/mogadishu',
        'description' => 'The capital and largest city of Somalia, known for its beautiful beaches and historic architecture.'
    ],
    [
        'name' => 'Hargeisa',
        'image' => 'https://images.unsplash.com/photo-1570129477492-45c003edd2be?w=800&auto=format&fit=crop&q=60',
        'url' => '/city/hargeisa',
        'description' => 'The capital of Somaliland, famous for its vibrant markets and cultural heritage.'
    ],
    [
        'name' => 'Garowe',
        'image' => 'https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?w=800&auto=format&fit=crop&q=60',
        'url' => '/city/garowe',
        'description' => 'The administrative capital of Puntland, known for its modern infrastructure.'
    ],
    [
        'name' => 'Kismayo',
        'image' => 'https://images.unsplash.com/photo-1444723121867-7a241cacace9?w=800&auto=format&fit=crop&q=60',
        'url' => '/city/kismayo',
        'description' => 'A historic port city with beautiful beaches and rich cultural heritage.'
    ],
    [
        'name' => 'Baidoa',
        'image' => 'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?w=800&auto=format&fit=crop&q=60',
        'url' => '/city/baidoa',
        'description' => 'Known for its agricultural markets and traditional Somali culture.'
    ],
    [
        'name' => 'Bosaso',
        'image' => 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=800&auto=format&fit=crop&q=60',
        'url' => '/city/bosaso',
        'description' => 'A major port city with beautiful coastal views and bustling markets.'
    ],
    [
        'name' => 'Beledweyne',
        'image' => 'https://images.unsplash.com/photo-1447752875215-b2761acb3c5d?w=800&auto=format&fit=crop&q=60',
        'url' => '/city/beledweyne',
        'description' => 'A historic city on the Shabelle River, known for its agricultural importance.'
    ],
    [
        'name' => 'Galkayo',
        'image' => 'https://images.unsplash.com/photo-1470770841072-f978cf4d019e?w=800&auto=format&fit=crop&q=60',
        'url' => '/city/galkayo',
        'description' => 'A major commercial hub known for its vibrant markets and cultural diversity.'
    ]
];
?>

<div class="cities-page">
    <div class="container py-5">
        <h1 class="text-center mb-5">Explore Cities in Somalia</h1>
        
        <div class="row g-4">
            <?php foreach ($cities as $city): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="city-card">
                        <a href="<?php echo $city['url']; ?>" class="text-decoration-none">
                            <div class="city-image-wrapper">
                                <img 
                                    src="<?php echo $city['image']; ?>" 
                                    alt="<?php echo $city['name']; ?>"
                                    class="city-image"
                                    loading="lazy"
                                >
                                <div class="city-overlay"></div>
                            </div>
                            <div class="city-content p-3">
                                <h3 class="city-name mb-2"><?php echo $city['name']; ?></h3>
                                <p class="city-description text-muted mb-0"><?php echo $city['description']; ?></p>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<style>
.cities-page {
    background-color: #f9fafb;
    min-height: 100vh;
}

.city-card {
    background: white;
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.city-card:hover {
    transform: translateY(-5px);
}

.city-image-wrapper {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.city-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.city-card:hover .city-image {
    transform: scale(1.05);
}

.city-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent);
}

.city-content {
    background: white;
}

.city-name {
    color: #111827;
    font-size: 1.25rem;
    font-weight: 600;
}

.city-description {
    font-size: 0.875rem;
    line-height: 1.5;
}
</style>

<?php include '../includes/footer.php'; ?> 