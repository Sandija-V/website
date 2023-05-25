<?php
	require_once 'Database.php';
	require_once 'Product.php';
	require_once 'DVD.php';
	require_once 'Book.php';
	require_once 'Furniture.php';

	// Retrieve products from the database
	$database = new Database();
	$conn = $database->getConnection();

	$sql = "SELECT * FROM products INNER JOIN product_details ON products.id = product_details.product_id";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$productsData = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$products = [];

// Loop through the products data and create objects based on the product type
	foreach ($productsData as $productData) {
		$id = $productData['id'];
		$sku = $productData['sku'];
		$name = $productData['name'];
		$price = $productData['price'];
		$type = $productData['type'];

		// Initialize $product with null or a default value
		$product = null;

		if ($type === 'dvd') {
			if (isset($productData['size'])) {
				$size = $productData['size'];
			} else {
				$size = null;
			}
			$product = new DVD($id, $sku, $name, $price, $type, $size);
			$product->setSize($size);
		} elseif ($type === 'book') {
			if (isset($productData['weight'])) {
				$weight = $productData['weight'];
			} else {
				$weight = null;
			}
			$product = new Book($id, $sku, $name, $price, $type, $weight);
			$product->setWeight($weight);
		} elseif ($type === 'furniture') {
			if (isset($productData['height']) && isset($productData['width']) && isset($productData['length'])) {
				$height = $productData['height'];
				$width = $productData['width'];
				$length = $productData['length'];
			} else {
				$height = null;
				$width = null;
				$length = null;
			}
			$product = new Furniture($id, $sku, $name, $price, $type, $height, $width, $length);
			$product->setHeight($height);
			$product->setWidth($width);
			$product->setLength($length);
		}

		// Check if $product is not null before setting common properties
		if ($product) {
			$product->setId($id);
			$product->setSku($sku);
			$product->setName($name);
			$product->setPrice($price);

			// Add the product object to the products array
			$products[] = $product;
		}
	}


// Display the products
//foreach ($products as $product) {
//     $product->displayProducts()
//}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Product List</title>
	<link rel="stylesheet" href="style.css">

	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<!-- <script>
		console.log('Document ready function executed');
		$(document).ready(function() {
			// Handle mass delete button click
			$('#delete-product-btn').click(function() {
				// Get the selected product IDs
				var selectedProducts = [];
				$('.delete-checkbox:checked').each(function() {
					selectedProducts.push($(this).val());
				});

				// Send the selected product IDs to the server for deletion
				$.ajax({
					type: 'POST',
					url: 'delete_products.php',
					data: { selectedProducts: selectedProducts },
					success: function(response) {
						// Handle the response from the server
						console.log(response); // Print or handle the response as needed

						// Refresh the page to update the product listing
						location.reload();
					},
					error: function(xhr, status, error) {
						// Handle errors
						console.error(error); // Log the error message
					}
				});
			});
		});
	</script> -->


</head>
<body>
	<div class="container">
		<div class="header">
			<h1 class="title">Product List</h1>
			<div>
				<button onclick="location.href='product_add.view.php'" class="btn">ADD</button>
				<button type="submit" class="btn" id="delete-product-btn">MASS DELETE</button>
			</div>
		</div>
		
		<form id="delete-product-form" action="delete_products.php" method="post">
			<div class="grid-container">
				
				<!-- Product listing section -->
				<?php foreach ($products as $product) { ?>
					<div class="card" data-id="<?php echo $product->getId(); ?>">
						<input type="checkbox" class="delete-checkbox" name="selectedProducts[]" value="<?php echo $product->getId(); ?>">
						<p>SKU: <?php echo $product->getSku(); ?></p>
						<h2>Name: <?php echo $product->getName(); ?></h2>
						<p>Price: $<?php echo $product->getPrice(); ?></p>
						<!-- Display additional product details based on type -->
						<?php if ($product instanceof DVD) { ?>
							<p>Size: <?php echo $product->getSize(); ?></p>
						<?php } elseif ($product instanceof Book) { ?>
							<p>Weight: <?php echo $product->getWeight(); ?></p>
						<?php } elseif ($product instanceof Furniture) { ?>
							<p>Dimensions: <?php echo $product->getHeight() . 'x' . $product->getWidth() . 'x' . $product->getLength(); ?></p>
						<?php } ?>
					</div>
				<?php } ?>

			</div>
		</form>

		<div class="footer">
			<p class="footer-text">A Simple Website</p>
		</div>
	</div>

	<script>
		$(document).ready(function() {
			$("#delete-product-btn").click(function() {
				// Get the selected product IDs
				var selectedProducts = [];
				$(".delete-checkbox:checked").each(function() {
					var productId = $(this).closest(".card").data("id");
					selectedProducts.push(productId);
				});

				// Submit the form with the selected product IDs
				if (selectedProducts.length > 0) {
					$("#delete-product-form").append('<input type="hidden" name="selectedProducts[]" value="' + selectedProducts.join(',') + '">');
					$("#delete-product-form").submit();
				} else {
					alert("No products selected.");
				}
			});
		});
	</script>

</body>
</html>