<?php
/**
 * @desc 工厂模式
 *
 */
interface Shape{
	public function draw();
}

class Rectangle implements Shape {
	
	public function draw() {
		echo "Inside Rectangle::draw() method.<br>";
	}
}


class Square implements Shape {

	public function draw() {
		echo "Inside Square::draw() method.<br>";
	}
}


class Circle implements Shape {

	public function draw() {
		echo "Inside Circle::draw() method.<br>";
	}
}


# Create Factory Class
class ShapeFactory {

	public function getShape($shapeType){
		if ($shapeType == null) {
			return null;
		}
		$lowerShapeType = strtolower($shapeType);
		
		$class = ucfirst($lowerShapeType);
		
		return new $class();
	}
}

$shapeFactory = new ShapeFactory();

$shape1 = $shapeFactory->getShape('Rectangle');
$shape1->draw();

$shape2 = $shapeFactory->getShape('Square');
$shape2->draw();

$shape3 = $shapeFactory->getShape('circle');
$shape3->draw();
