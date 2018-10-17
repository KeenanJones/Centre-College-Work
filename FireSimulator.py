#Keenan Jones
#Forest Fire Project

from graphics import *
from Tree import *
import random
########################### FireSimulator.py ##################

def main():
  win = GraphWin("Forest Fire",700,500)
  regrow = closeorregrow(win) #gets a true or false to regrow or not 
  forestlist = createForest(win) #creates the forest
  probability = getPercent(win)
  done = False
  count = 0
  while not done:
    point = win.getMouse() #gets a point 
    X = point.getX() #classifies it as x and y 
    Y = point.getY()
    if (X > 450 and X < 600) and (Y > 300 and Y < 335): #checks for the exit box
      done = True
      win.close() #closes window if exit is clicked]
      break
    elif (X > 450 and X < 600) and (Y > 200 and Y < 235): #checks to see if in regrow box
      done = True
      forestlist = createForest(win) #calls this function
      count = 0
    elif (X < 310 and X > 0) and (Y > 0 and Y < 310): #Sees if the click is in the forest
      first_tree = whichtree(win, X, Y, forestlist) #calls the which tree function
      first_tree.set_state() #sets the first tree state to 2
      first_tree.drawtree(win) #draws this homie
      prob = float(probability.getText())
    else:
      done = False #sets it equal to false
    count += 1 #adds to the count
    if count <= 1: #if count is less than 1
      burn = isburning(forestlist) #checks to see if anything is burning 
      while burn == True: #while something is burning 
        burnbitch(win, forestlist, prob) #starts burning 
        makesure(win, forestlist) #calls makesure
        time.sleep(.1) #time step
        resetjustchanged(forestlist) #resets the just changed
        burn = isburning(forestlist) #checks for burning again
      makesure(win, forestlist) #calls makesure
      findleft(forestlist, win) #finds what percent is left
    
      
def closeorregrow(win):
  regrowbox = Rectangle(Point(450,200), Point(600, 235)) #creates the exit box
  regrowbox.draw(win)
  regrowbox.setFill('Green')
  regrowword = Text(Point(525,217.5),"Grow Forest") #creates the exit word
  regrowword.draw(win)
  closebox = Rectangle(Point(450,300), Point(600, 335)) #creates the exit box
  closebox.draw(win)
  closebox.setFill('Red')
  closeword = Text(Point(525,317.5),"Exit") #creates the exit word
  closeword.draw(win)
  percentbox = Rectangle(Point(450, 250), Point(600, 285)) #creates the box
  percentbox.draw(win)
  percentbox.setFill('Yellow') #sets the color
  percentword = Text(Point(500, 267.5),"Probability to burn: ")
  percentword.draw(win)


def getPercent(win):
  probability = Entry(Point(570, 267.5), 5) #gets an entry box
  probability.draw(win)
  return probability


def createForest(win):
  forestlist = []
  for column in range(1,12): #iterates over range
    for row in range(1,11): #iterates over range 
      rowscale = row * 31 #scales the row
      columnscale = column * 31 #scales the columns
      point = Point(rowscale, columnscale) #creates the point 
      tree = Tree(row, column, point, 1, win, False) #calls Tree
      forestlist.append(tree) #adds to the list
      tree.drawtree(win)  #draws my trees finally 
  return forestlist


def whichtree(win, X, Y, forestlist): #creates a function to start a tree on fire
  for obj in forestlist: #iterates over all the trees
    X1 = obj.get_X() #takes the x coordinate
    Y1 = obj.get_Y() #takes the y coordinate
    if (X1 - X) < 15 and (X1 - X) > -15 and (Y1 - Y) < 15 and (Y1 - Y) > -15:
      #sees if the tree is within 15 of the click
      return obj #returns the tree closest

def burnbitch(win, forestlist, prob): #defines function
  try:
    percent = float(prob)*100 #gets the percent
    for obj in forestlist: #iterates over obj in list
      num = random.randint(1,100) #gets a random number
      lastint = int((forestlist.index(obj)))-1 #figures out the index of all the trees above below right and left of obj
      nextint = int((forestlist.index(obj)))+1
      tenbeforeint = int((forestlist.index(obj)))-10
      tenafterint = int((forestlist.index(obj)))+10
      if num <= percent and forestlist[lastint].get_state() > 1 and forestlist[lastint].get_state() <4 and forestlist[lastint].get_justchanged() != True and obj.get_state() == 1 and int((forestlist.index(obj) - 1) / 10) == int((forestlist.index(obj) / 10)) and forestlist.index(obj) < 100:
        obj.set_state() #figures out when to change the ones to the right 
        obj.set_justchanged()
        #print("r")
      elif num <= percent and forestlist[nextint].get_state() > 1 and forestlist[nextint].get_state() <4 and forestlist[nextint].get_justchanged() != True and obj.get_state() == 1 and int((forestlist.index(obj) - 1) / 10) == int((forestlist.index(obj) / 10)) and forestlist.index(obj) < 100:
        obj.set_state() #figures when to change the left
        obj.set_justchanged()
        #print("l")
      elif num <= percent and forestlist[tenbeforeint].get_state() > 1 and forestlist[tenbeforeint].get_state() <4 and forestlist[tenbeforeint].get_justchanged() != True and obj.get_state() == 1 and forestlist.index(obj) < 100:
        obj.set_state() #figures out when to change the down
        obj.set_justchanged()
        #print("down")
      elif num <= percent and forestlist[tenafterint].get_state() > 1 and forestlist[tenafterint].get_state() <4 and forestlist[tenafterint].get_justchanged() != True and obj.get_state() == 1 and forestlist.index(obj) < 100:
        obj.set_state() #figures out when to change the up
        obj.set_justchanged()
        #print("up")

  except IndexError:
    pass

def makesure(win, forestlist): 
  for obj in forestlist: #iterates over list
    if obj.get_state() > 1 and obj.get_justchanged() == False: #if the state is burning and unchanged is false, change it to true
      obj.set_state()
  for obj1 in forestlist: 
    obj1.drawtree(win) #draws the trees

def isburning(forestlist): #checks to see what is still burning 
  done = False
  for obj in forestlist[:101]: #goes over the list
    if obj.get_state() == 2 or obj.get_state == 3:
      done = True
      return True #shows true of it is still burning 
  return done

def regrow(win, forestlist):
  for obj in forestlist: #regrows the forest
    obj.reset_state()
    obj.drawtree(win)
  
def resetjustchanged(forestlist): #resets the ones that are changed
  for obj in forestlist:
    if obj.get_justchanged() == True:
      obj.set_justchanged()

def findleft(forestlist, win): #finds what is left in the forest 
  counter = 1
  for obj in forestlist:
    if obj.get_state == 4:
      counter += 1
      final = counter / 1
      finalstate = Text(Point(300,300),"The percent of the forest burned is"+str(final))
      finalstate.draw(win)
      time.sleep(2)
      finalstate.undraw(win)
    
    
 
  
main()
 
