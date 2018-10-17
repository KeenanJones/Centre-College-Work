import java.util.*;

public class Permutation {

	//This initiallizes the global variables that will need to be in all functions
	ArrayList finalPermutationsList = new ArrayList();
	public int commandLineInput;


	public Permutation(String howManyPermutations) {
		
		commandLineInput = Integer.parseInt(howManyPermutations);

		ArrayList resultOfPermutations = new ArrayList();

		// Format permutation and add to list
		int[] firstPermutation = new int[commandLineInput];
		firstPermutation = getFirstPermutation(commandLineInput);

		String resultOfFirstPerm = formatPerm(firstPermutation);
		resultOfPermutations.add(resultOfFirstPerm);

		finalPermutationsList = computePermutations(commandLineInput, resultOfPermutations, firstPermutation);

	}


	//This makes the very first permutation [1,2,3,...,n]
	public static int[] getFirstPermutation(int commandLineInput) {
		
		int[] permutation = new int[commandLineInput];

		int count = 1;

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


	//This just prints the permutations once they are all in order
	public void printPermutations() {

		for (Object element : finalPermutationsList) { 

			System.out.println(element);
		}
	}


	public static void main(String[] args) {
		
		Permutation whatThePerm = new Permutation(args[0]);
		
		whatThePerm.printPermutations();

	}
}