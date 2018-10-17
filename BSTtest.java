//import TEST_LIB;
import java.util.List;
import java.util.ArrayList;
public class BSTTest
{
   public static void main(String[] args)
   {
      /// first tree
      BSTree tree = new BSTree();
      assert tree.getSize()==0;
      assert tree.isEmpty()==true;
      tree.insert(33);
      tree.insert(22);
      tree.insert(44);
      assert tree.isEmpty()==false;
      assert tree.retrieveDepth(22)==1;
      assert tree.retrieve(22)==22;
      assert tree.retrieve(444)==null;
      assert tree.getSize()==3;
      assert tree.largest()==44;
      assert tree.sum()==99;
      List<Integer> thelist = tree.toList();
      assert thelist.get(0)<thelist.get(1)==true;
      
      
      
      /// second tree
      BSTree t1 = new BSTree();
      BSTree t2 = new BSTree();
      assert t1.largest()==null;
      assert t1.myEquals(t2)==true;
      assert t1.myEquals(tree)==false;
      assert tree.myEquals(t1)==false;
      t1.insert(33);
      t1.insert(22);
      t1.insert(44);
      assert t1.myEquals(tree)==true;
      t1.insert(3);
      t1.insert(82);
      t1.insert(54);
      assert t1.sum()==238;
      assert t1.largest()==82;
      t1.insert(300);
      t1.insert(100);
      t1.insert(1000);
      assert t1.sum()==1638;
      assert t1.largest()==1000;
      assert t1.myEquals(tree)==false;
      
      
      //2 barely different trees
      BSTree tt = new BSTree();
      BSTree tm = new BSTree();
      BSTree tb = new BSTree();
      BSTree ts = new BSTree();
      BSTree t = new BSTree();

      tm.insert(50);
      tm.insert(25);
      assert tm.largest()==50;
      tm.insert(75);
      assert tm.largest()==75;
      tm.insert(12);
      assert tm.largest()==75;
      tm.insert(32);
      tm.insert(61);
      tm.insert(78);
      tm.insert(6);
      tm.insert(3);
      tm.insert(88);
      tm.insert(102);
            
      tt.insert(50);
      tt.insert(25);
      tt.insert(75);
      tt.insert(12);
      tt.insert(32);
      tt.insert(61);
      tt.insert(78);
      tt.insert(6);
      tt.insert(3);
      tt.insert(88);
      tt.insert(102);
      assert tm.myEquals(tt)==true;

      tb.insert(102);
      tb.insert(88);
      tb.insert(78);
      tb.insert(75);
      tb.insert(61);
      tb.insert(50);
      tb.insert(32);
      tb.insert(25);
      tb.insert(12);
      tb.insert(6);
      tb.insert(3);
      assert tb.retrieveDepth(61)==4;
      assert tt.myEquals(tb)==false;
       
      ts.insert(50);
      ts.insert(25);
      ts.insert(75);
      ts.insert(12);
      ts.insert(32);
      ts.insert(61);
      ts.insert(78);
      assert tb.retrieveDepth(78)==2;
      ts.insert(6);
      ts.insert(3);
      ts.insert(88);
      assert tt.myEquals(ts)==false;
      assert ts.myEquals(tt)==false;
      t.insert(50);
      t.insert(75);
      t.insert(12);
      t.insert(32);
      t.insert(61);
      t.insert(78);
      t.insert(6);
      t.insert(3);
      t.insert(88);
      t.insert(102);
      assert t.myEquals(tt)==false;
      assert tt.myEquals(t)==false;
      
      

     



   }

}