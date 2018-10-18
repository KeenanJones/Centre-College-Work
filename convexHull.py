from graphics import *
from itertools import *

#Makes an empty array
arrayOfPoints = []
nextArrayOfPoints = []

#Read in the stuff from the file 
fileOfPoints = open('points.txt', 'r')

arrayOfPoints = fileOfPoints.readlines() 

#Splits on the comma
for x in arrayOfPoints:
	string = x.strip('\n')
	individualPoints = string.split(',')
	nextArrayOfPoints.append(individualPoints)


#Makes a string an integer
for x in nextArrayOfPoints:
	count = 0
	for y in x:
		int_y = int(y)
		x[count] = int_y
		count = count + 1

#This just prints the pairs of points to graph
#print(nextArrayOfPoints)


#Making the initial point graph
window = GraphWin("Where The Points At", 533, 533)


#Makes the whole outline of the grpah
line1 = Line(Point(33,33), Point(33,500))
line1.draw(window)
line1.setWidth(3)
line2 = Line(Point(33,33), Point(500,33))
line2.draw(window)
line2.setWidth(3)
line3 = Line(Point(500,33), Point(500,500))
line3.draw(window)
line3.setWidth(3)
line4 = Line(Point(500,500), Point(33,500))
line4.draw(window)
line4.setWidth(3)


#makes all of the verticle lines in the grid
for x in range(2,32):
	X = (x+1)*15.61
	firstY = 33;
	lastY = 500;
	line = Line(Point(X,firstY), Point(X,lastY))
	line.draw(window)
	if x == 16:
		line.setWidth(3)
		

#makes all the horizontal lines
for x in range(2,32):
	Y = (x+1)*15.61
	firstX = 33;
	lastX = 500;
	line = Line(Point(firstX,Y), Point(lastX,Y))
	line.draw(window)
	if x == 16:
		line.setWidth(3)

#Plots the points into the graph (maybe)
xValue = 0
yValue = 0
for x in nextArrayOfPoints:
	xValue = x[0]
	yValue = x[1]
	graphX = 265.37 + (xValue * 15.61)
	graphY = 265.37 + (yValue * -15.61)
	point = Circle(Point(graphX,graphY), 5)
	point.setFill("black")
	point.draw(window)


#Gets all of the combinations
pointlist = []
perm = []
count1 = 0
count2 = 1
count3 = 1

for x in nextArrayOfPoints:
	point1 = nextArrayOfPoints[count1]
	for y in range(1,len(nextArrayOfPoints)):
		if(count2 != len(nextArrayOfPoints)):
			point2 = nextArrayOfPoints[count2]
			pointlist.append(point1)
			pointlist.append(point2)
			perm.append(pointlist)
			pointlist = []
			count2 = count2 + 1
	count1 = count1 + 1
	count3 = count3 + 1
	count2 = count3



listOfP1 = []
listOfP2 = []
listOfX1 = []
listOfX2 = []
listOfY1 = []
listOfY2 = []

for i in perm:
	listOfP1.append(i[0])
	listOfP2.append(i[1])

for i in listOfP1:
	listOfX1.append(i[0])
	listOfY1.append(i[1])

for i in listOfP2:
	listOfX2.append(i[0])
	listOfY2.append(i[1])

listOfA = []
listOfB = []
listOfC = []
X1Y2 = []
Y1X2 = []

counter = 0
for i in listOfY2:
	a = i - listOfY1[counter]
	counter = counter + 1
	listOfA.append(a)

counter = 0
for i in listOfX1:
	b = i - listOfX2[counter]
	counter = counter + 1
	listOfB.append(b)

counter = 0
for i in listOfX1:
	product = i * listOfY2[counter]
	counter = counter + 1
	X1Y2.append(product)
	
counter = 0
for i in listOfY1:
	product = i * listOfX2[counter]
	counter = counter + 1
	Y1X2.append(product)

counter = 0
for i in X1Y2:
	c = i - Y1X2[counter]
	counter = counter + 1 
	listOfC.append(c)


#This does all the calculations to see what is in the convex hull
arrayOfTestPoints = []
points = []
thiscount = 0
for i in perm:
	howmanytime = 0
	for x in nextArrayOfPoints:
		if((x != i[0]) and (x != i[1]) and howmanytime == 0):
			points.append(x)
			thiscount = thiscount + 1
	arrayOfTestPoints.append(points)
	howmanytime = 1
	points = []
		
#This results in the array of test points, which is an array of the points I need to do math on
count = 0
counter = 0
linesInConvexHull = []
for i in arrayOfTestPoints:
	arrayOfFinal = []
	for individualPoint in i:
		x_value = individualPoint[0]
		y_value = individualPoint[1]
		a = listOfA[count]
		b = listOfB[count]
		c = listOfC[count]
		aX = x_value * a
		bY = y_value * b
		axbyc = aX + bY - c
		arrayOfFinal.append(axbyc)

	well = "true"

	if arrayOfFinal[0] >= 0:
		for i in arrayOfFinal:
			if i < 0:
				well = "false"

	if arrayOfFinal[0] < 0:
		for i in arrayOfFinal:
			if i >= 0:
				well = "false"

	if well == "true":
		linesInConvexHull.append(perm[counter])
	count = count + 1
	counter = counter + 1

#Results in an array linesInConvexHull that need to be graphed
for x in linesInConvexHull:
	point1 = x[0]
	point2 = x[1]
	x1 = point1[0]
	x2 = point2[0]
	y1 = point1[1]
	y2 = point2[1]
	graphX1 = 265.37 + (x1 * 15.61)
	graphY1 = 265.37 + (y1 * -15.61)
	graphX2 = 265.37 + (x2 * 15.61)
	graphY2 = 265.37 + (y2 * -15.61)
	line = Line(Point(graphX1,graphY1), Point(graphX2,graphY2))
	line.setFill("red")
	line.setWidth(3)
	line.draw(window)



#Once you click the window it closes
window.getMouse() 
window.close()