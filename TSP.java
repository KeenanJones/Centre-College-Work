import java.util.Scanner;
import java.io.BufferedReader;
import java.io.FileReader;
import java.io.IOException;
import java.util.ArrayList;
import java.io.File;
import java.util.ArrayList;
import java.util.List;


// Write a program that solves the traveling salesman problem using the brute force method.  You will need your solution to problem 2 to do this.  You may or may not need to modify your solution to number 2 slightly to make this work.  The data for the program will be in tsp_input.txt which will be located in the same folder as the .class file.

// The input file I use to test your program will have the format of the tsp_input.txt file bundled with the auto grader.  You should assume that the cities are numbered 0 to n-1 and for this problem, we will not assume there is a home/original city.  Thus, we will print out all of the tours in lexicographic order, one per line, with the cities separated by ->.  The output lines should look like:

// 0->1->2->3->4->0   Score: 1164	

// After all the lines like that, we will print out the cheapest tour cost and the cheapest tour like this:

// The cheapest tour costs: 283
// The cheapest tour was: 0->1->2->4->3->0


public class TSP {

	ArrayList finalCostList = new ArrayList();

	//Makes the location objects
	public static class Location {

		int cityNumber;
		int[] costs;
		int score;

		public int getCityNumber() {
			return cityNumber;
		}

		public int[] getCosts() {
			return costs;
		}



		public Location(int myCityNumber, int[] whatItCostsArray) {
			cityNumber = myCityNumber;
			costs = whatItCostsArray;
		}

	}

	//Reads the file and returns an array of location objects populated correctly
	public static ArrayList<Location> importFile() {
		ArrayList location = new ArrayList();
		String directoryPath = "./tsp_input.txt";
		String input = "";
		int cityCount = 1;

		try (BufferedReader read = new BufferedReader(new FileReader(directoryPath))) {
			
			//Reads the file and fixes the strings to be workable
			try {
				File file = new File("tsp_input.txt");
				FileReader fileReader = new FileReader(file);
				BufferedReader bufferedReader = new BufferedReader(fileReader);
				StringBuffer stringBuffer = new StringBuffer();
				String line;

				while ((line = bufferedReader.readLine()) != null) {
					stringBuffer.append(line);
					stringBuffer.append("\n");
				}

				fileReader.close();

				//This makes a string array of the costs
				String[] splitedCityCosts = stringBuffer.toString().split("\\r?\\n");

				//This makes a int array to be filled with arrays of the costs
				ArrayList splitCityCostsInt = new ArrayList();
				
				int count = 1;
				// Creates the integer array.
				for (int i = 1; i < splitedCityCosts.length; i++) {
				    //Iterates through with -1 34 65 248 542

				    String[] splittedIndividual = splitedCityCosts[i].toString().split(" ");

				    int[] splittedIndividualIntArray = new int[splittedIndividual.length];
				    //gets each individual cost
				    for (int j=0; j < splittedIndividual.length; j++) {

						int holderInt = Integer.parseInt(splittedIndividual[j]);
				    	splittedIndividualIntArray[j] = holderInt;
				    }
				
				Location newLocation = new Location(count, splittedIndividualIntArray);
				count++;
				location.add(newLocation);
				}				


		} catch (IOException e) {
			e.printStackTrace();
		}

		}
		catch (IOException e) {
			System.out.println("Error reading file.");
		}

		return (location);
	}

	public static void getFinalCosts() {

		

	}





	//----------------------------------------------------------
	
		//This makes the very first permutation [1,2,3,...,n]
	public static int[] getFirstPermutation(int commandLineInput) {
		
		int[] permutation = new int[commandLineInput];

		int count = 0;

		for (int i = 0; i < commandLineInput; i++) {
			
			permutation[i] = count;

			count++;
		}

		return permutation;
	}

	//This is the function that takes an array and formats it into a string with the proper spacing
	// as shown in the example (hopefully)
	public static String formatPerm(int[] myList) {
		
		String stringOfPerm = "";
		int count = myList.length;

		for (int i = 0; i < count; i++) {

			stringOfPerm = stringOfPerm + myList[i];

			if (i != (count - 1)) {

				stringOfPerm = stringOfPerm + " ";
			}
		}

		return stringOfPerm;
	}

	public static ArrayList computePermutations(int numPermutations, ArrayList permutationList, int[] firstPermutation) {
		
		int index = 0;
		int largestIndex = 0;
		int nextIndex = 0; 
		boolean areTheyConsecutiveInts = false;

		ArrayList result = new ArrayList();
		result = permutationList;

		while (true) {

			index = 0;
			areTheyConsecutiveInts = false; // always choose the first int when consecutive

			int size = numPermutations - 1;

			for (int i = 0; i < size; i++) {
				
				int num1 = firstPermutation[i];
				int num2 = firstPermutation[i + 1];

				//ai < ai+1"
				if (num1 < num2) {
					areTheyConsecutiveInts = true;
					index = i; 
				}
			}

			//If they are consecutive at this point then the loop should break
			if (areTheyConsecutiveInts == false) {
				
				break;
			}

			
			//Checks for the step about the largest index
			largestIndex = 0;
			nextIndex = index + 1;

			//Gets the largest 
			for (int i = nextIndex; i < numPermutations; i++) {
				
				if (firstPermutation[i] > firstPermutation[index]) {
					
					largestIndex = i;
				}
			}

			//Switches the numbers (a and j)
			int num3 = firstPermutation[index];
			int num4 = firstPermutation[largestIndex];
			firstPermutation[index] = num4;
			firstPermutation[largestIndex] = num3;


			//Reverse the order step
			int sizeCheck = firstPermutation.length - 1;

			if ((index + 1) != sizeCheck) {
				
				int[] reversePerm = new int[firstPermutation.length - (index + 1)];
				int count = 0;

				for (int i = (index + 1); i < firstPermutation.length; i++) {
					
					reversePerm[count] = firstPermutation[i];
					count++;
				}

				// Reverse order
				int reverseCount = index + 1;

				for (int j = reverseCount; j < firstPermutation.length; j++) {
					
					count = count - 1;
					firstPermutation[j] = reversePerm[count];
				}
			}

			result.add(formatPerm(firstPermutation));
		}

		return result;
	}

	public static ArrayList comoputeEndLoco(ArrayList locoListWithoutEnd) {
		ArrayList finalCostWithEndLoco = new ArrayList();

		for (int i = 0; i < locoListWithoutEnd.size(); i++) {

			Object locoloco = locoListWithoutEnd.get(i);
			String locoConvertedToString = String.valueOf(locoloco);

			String locoConvertedToStringWithEnd = "";
			String firstLoco = locoConvertedToString.substring(0, 1);
			locoConvertedToStringWithEnd = locoConvertedToString + " " + firstLoco;
			finalCostWithEndLoco.add(locoConvertedToStringWithEnd);

		}

		return finalCostWithEndLoco;

	}

	public static ArrayList getScores(ArrayList finalCostWithEndLoco, ArrayList<Location> cityList) {
		ArrayList scoreArray = new ArrayList();

		//We have the list of all the permutations
		//We have the list of all the location objects
			//Which has: city number and cost array

		for (int i = 0; i < finalCostWithEndLoco.size(); i++) {
			Object locoloco = finalCostWithEndLoco.get(i);
			String locoConvertedToString = String.valueOf(locoloco);
			String[] splittedLoccoArray = locoConvertedToString.split(" ");
			
			String firstLoco = "";
			String secondLoco = "";
			int totalCost = 0;
			for (int j =0; j<splittedLoccoArray.length - 1; j++) {
				firstLoco = splittedLoccoArray[j];
				secondLoco = splittedLoccoArray[j + 1];

				int firstLocoInt = Integer.parseInt(firstLoco);
				int secondLocoInt = Integer.parseInt(secondLoco);

				int[] flightPriceArray = cityList.get(firstLocoInt).getCosts();
				int flightPrice = flightPriceArray[secondLocoInt];

				totalCost = totalCost + flightPrice;

			}
		
		scoreArray.add(totalCost);

		}


		return scoreArray;

	}

	//Finds the position of the best score (cheapest flight)
	public static int findPositionOfBestScore(ArrayList scoreArray) {

		

		int currentBestScore = 1000000000;
		int currentBestScorePos = 100000000;
		for (int i = 0; i < scoreArray.size(); i++) {
			
			Object thisScoreObject = scoreArray.get(i);
			int thisScoreInt = (Integer) thisScoreObject;

			if (thisScoreInt < currentBestScore) {

				currentBestScore = thisScoreInt;
				currentBestScorePos = i;

			}
		
		}

		return currentBestScorePos;
			
	}

	public static boolean printResults(ArrayList<Location> cityList, ArrayList finalCostWithEndLoco, ArrayList scoreArray, int positionOfBestScore) {


		for (int i = 0; i < finalCostWithEndLoco.size(); i++) {
			Object objectOfOrder = finalCostWithEndLoco.get(i);
			String stringOfOrder = (String) objectOfOrder;

			String toPrint = "";
			//Makes the arrows in the string
			toPrint = stringOfOrder.replaceAll(" ", "->").toLowerCase();

			System.out.println(toPrint + "   " + "Score: " + scoreArray.get(i));

		}

		System.out.println("The cheapest tour costs: " + scoreArray.get(positionOfBestScore));
		
		Object objectOfOrder = finalCostWithEndLoco.get(positionOfBestScore);
		String stringOfOrder = (String) objectOfOrder;
		String toPrint = "";
		toPrint = stringOfOrder.replaceAll(" ", "->").toLowerCase();

		System.out.println("The cheapest tour was: " + toPrint);

		return true;
	}


	//------------------------------------------------------------------
	
	public static void main(String[] args) {

	//Gets the array of location objects with their city number and their cost array
	ArrayList<Location> cityList = new ArrayList();
	cityList = importFile();

	//Gets the first permutation [1,2,3,4,5]
	int[] firstPerm = new int[cityList.size()];
	firstPerm = getFirstPermutation(cityList.size());


	ArrayList resultOfPermutations = new ArrayList();

	String resultOfFirstPerm = formatPerm(firstPerm);
	resultOfPermutations.add(resultOfFirstPerm);

	ArrayList finalCost = new ArrayList();

	//Returns a list of the needed permutations to calculate in the right order but without the ending spot
	finalCost = computePermutations(cityList.size(), resultOfPermutations, firstPerm);


	ArrayList finalCostWithEndLoco = new ArrayList();

	//Gets a list of all location permutations with the return to the start 
	finalCostWithEndLoco = comoputeEndLoco(finalCost);


	//Gets an array with all of the costs
	ArrayList scoreArray = new ArrayList();
	scoreArray = getScores(finalCostWithEndLoco, cityList);

	//Finds the position of the best score (cheapest flight)
	int positionOfBestScore = 0;
	positionOfBestScore = findPositionOfBestScore(scoreArray);

	boolean didItPrint = false;
	didItPrint = printResults(cityList, finalCostWithEndLoco, scoreArray, positionOfBestScore);




	}
}