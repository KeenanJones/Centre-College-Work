import TEST_LIB;

public class CustomerTest
{  
   public static void main(String[] args)
   {
      Customer C1 = new Customer(0, 0, 0);
      Customer C2 = new Customer(1, 1, 1);
      Customer C3 = new Customer(100, 100, 100);
      Customer C4 = new Customer(0, 1, 100);
      Customer C5 = new Customer(0, 1, 100);
      
      Customer.WorthComparator Ca = new Customer.WorthComparator();
      
      assert Ca.compare(C1, C2)==-1:"Should be -1 not";
      assert Ca.compare(C1, C3)==-1:"Should be -1 not";
      assert Ca.compare(C3, C1)==1:"Should be 1 not";
      assert Ca.compare(C1, C4)==0:"Should be -1 not";
      
      
      Customer.LoyaltyComparator Cb = new Customer.LoyaltyComparator();
      
      assert Cb.compare(C1, C2)==-1;
      assert Cb.compare(C1, C3)==-1;
      assert Cb.compare(C3, C1)==1;
      assert Cb.compare(C4, C2)==0;
      
      Customer.WorthPoliteComparator Cc = new Customer.WorthPoliteComparator();
      
      
      assert Cc.compare(C1, C4)==-1;
      assert Cc.compare(C1, C2)==-1;
      assert Cc.compare(C3, C2)==1;
      assert Cc.compare(C4, C5)==0;
   
   
      
      
      
      PriorityQueue<Customer> pque = new PriorityQueue<Customer>(Ca);
      assert pque.isEmpty()==true;
      pque.push(C4);
      pque.push(C3);
      pque.push(C1);
      pque.push(C1);
      pque.push(C5);
      pque.push(C2);
      assert pque.pop()==C3;
      assert pque.pop()==C2;
      assert pque.pop()==C5;
      assert pque.pop()==C1;
      assert pque.pop()==C1;
      assert pque.pop()==C4;
      assert pque.isEmpty()==true;
     


   }  

}
