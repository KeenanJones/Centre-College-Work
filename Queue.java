public class Queue<T>
{
    //be sure that your attributes are protected, so subclasses can use them
   protected Node front;
   protected Node back;
   class Node
   {
      T tobj;
      Node next;
      
      public Node(T data, Node n)
      {
         this.tobj = data;
         this.next = n;
      }
   }


   public Queue()
   {
      front=null;
      back=null;

   }


    /**Adds val to the end of the queue
     */
   public void push(T val)
   {
      if (isEmpty())
      {
         Node n = new Node(val, null);
         front = n;
         back = n;
      } 
      else 
      {
         Node n = new Node(val, null);
         back.next = n;
         back = n;
      }
   }


    /**
       removes and returns the oldest value in the queue
       throws QueueUnderFlowException if the queue is empty
     */
   public T pop()
   {
       if (front!= null)
       {
           T store = front.tobj;
           front = front.next;
           return store; 
       }
       else
       {
         throw new QueueUnderFlowException(); 
       }
   }    


    /**
      returns true if the queue is empty
     */

   public boolean isEmpty()
   {
       if (front==null)
       {
         return true;
       }
       else
       {
         return false;
       }
          
   }

}
